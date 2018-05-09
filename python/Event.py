# coding:utf-8
import requests
from lxml import html
import os
import time
import re
import sys

reload(sys)
sys.setdefaultencoding('utf-8')
from bs4 import BeautifulSoup

global alltext
alltext = ''

class Event(object):
    def __init__(self, link, path):
        global alltext
        self.StorePath = path
        self.EventUrl = link
        self.EventId = 0
        self.EventName = ''
        self.EventOpentime = ''
        self.EventClosetime = ''
        self.EventBeginDay = ''
        self.EventEndDay = ''
        self.EventAddress = ''
        self.EventPrice = ''
        self.EventContent = ''
        self.EventImgPath = ''
        self.EventDayList = []
        self.EventNumInterest = 0
        self.EventNumAttend = 0
        try:
            self.request = self.make_request()
        except:
            print "request error: ", link
            time.sleep(0.5)
            pass


        try:
            self.get_info()
            self.write_info()
        except:
            print "get and store error: ", link
            pass
        alltext += str(self.EventId) + ','

    def make_request(self):
        return requests.get(self.EventUrl).content

    def get_info(self):
        """get information of this event"""
        sel = html.fromstring(self.request)
        # 获取各字段
        # id
        self.EventId = re.search("/\d+/", self.EventUrl).group()[1:-1]
        # 展览名
        self.EventName = str(sel.xpath('//*[@id="event-info"]/div[1]/h1/text()')[0].decode('utf-8')).strip().replace(
            '\n', '').replace("\"", '”').replace(",", "，")
        timestr = sel.xpath('//*[@id="event-info"]/div[1]/div[1]/ul/li/text()')[0].decode('utf-8')
        print u"爬取：", self.EventName.decode('utf-8'), self.EventUrl
        # 调用获取日期函数
        self.EventBeginDay, self.EventEndDay, self.EventDayList = getDate(timestr, sel)

        ifExistTime = re.search(u":", timestr)
        if (ifExistTime):
            opTimeHour = re.findall(":\d+", timestr)[0]
            clTimeHour = re.findall(":\d+", timestr)[1]
            opTime = '{}:{}'.format(re.findall("\d+:", timestr)[0][0:-1], opTimeHour[1:len(opTimeHour)])
            clTime = '{}:{}'.format(re.findall("\d+:", timestr)[1][0:-1], clTimeHour[1:len(clTimeHour)])
        else:
            moreTime = sel.xpath('//*[@id="event_datetime_1"]/div[2]/div[2]/span/text()')[0]
            opTimeHour = re.findall(":\d+", moreTime)[0]
            clTimeHour = re.findall(":\d+", moreTime)[1]
            opTime = '{}:{}'.format(re.findall("\d+:", moreTime)[0][0:-1], opTimeHour[1:len(opTimeHour)])
            clTime = '{}:{}'.format(re.findall("\d+:", moreTime)[1][0:-1], clTimeHour[1:len(clTimeHour)])

        self.EventOpentime = opTime
        self.EventClosetime = clTime
        # 单张图片展示 图片url地址
        self.EventImgPath = sel.xpath('//*[@id="poster_img"]/@src')[0].decode('utf-8')

        # 展览地址
        # 展览地址
        try:
            address = sel.xpath('//*[@id="event-info"]/div[1]/div[2]/span[2]/span[1]/text()')[0].decode('utf-8') \
                      + sel.xpath('//*[@id="event-info"]/div[1]/div[2]/span[2]/span[2]/text()')[0].decode('utf-8') \
                      + sel.xpath('//*[@id="event-info"]/div[1]/div[2]/span[2]/span[3]/text()')[0].decode('utf-8')
        except:
            address = sel.xpath('//*[@id="event-info"]/div[1]/div[2]/span[2]/span[2]/text()')[0].decode("utf-8")


        self.EventAddress = str(address).strip(u' ')
        # 展览票价
        self.EventPrice = sel.xpath('//*[@id="event-info"]/div[1]/div[3]/text()')[1].decode('utf-8').strip().replace(
            '\n', '')

        # 感兴趣人数
        self.EventNumInterest = sel.xpath('//*[@id="event-info"]/div[1]/div[6]/span[1]/text()')[0]

        # 要参加人数
        self.EventNumAttend = sel.xpath('//*[@id="event-info"]/div[1]/div[6]/span[3]/text()')[0]

        # 沉睡2s 开始获取详情介绍 获取整个html代码 插入进主页里
        time.sleep(2)
        soup = BeautifulSoup(self.request, 'lxml')
        # 详情的代码块
        self.EventContent = str(soup.find(id='link-report').prettify())

    def write_info(self):
        """"write content of this event"""
        print u"正在保存:", self.EventName.decode('utf-8')

        if (os.path.exists(self.StorePath)):
            pass
        else:
            os.mkdir(self.StorePath)
        # 保存较难保存的内容
        dirName = self.StorePath + str(self.EventId)
        if (os.path.exists(dirName)):
            storeFile(dirName, '//content.txt', self.EventContent)
        else:
            # 新建文件夹
            os.mkdir(dirName)
            storeFile(dirName, '//content.txt', self.EventContent)
        storeFile(self.StorePath, str(self.EventId) + '.txt', self.outEachMsg())
        if (self.EventDayList):
            list = ''
            for each in self.EventDayList:
                list = list + each + ','
            storeFile(dirName, '//timelist.txt', list[0:-1])
        print u'保存结束'

    def outEachMsg(self):
        line = str(self.EventId) + ',' + self.EventUrl + ',' + self.EventName \
               + ',' + self.EventOpentime + ',' + self.EventClosetime + ',' + \
               self.EventBeginDay + ',' + self.EventEndDay + ',' + \
               self.EventAddress + ',' + self.EventPrice + ',' + self.EventImgPath \
               + ',' + str(self.EventNumInterest) + ',' + str(self.EventNumAttend)
        return line


class Page(object):
    def __init__(self, start, url):
        self.start = start
        self.baseurl = url + '?start='
        self.url = self.make_url()
        self.make_request()
        self.events_links = self.get_events()

    def make_url(self):
        new_url = self.baseurl + str(self.start)
        return new_url

    def make_request(self):
        baseUrl = self.url
        self.selector = html.fromstring(requests.get(baseUrl).content)
        return self.selector

    def get_events(self):
        """return event links as a list"""
        urls = []
        for i in self.selector.xpath('//*[@id="db-events-list"]/ul/li/div[1]/a/@href'):
            urls.append(i)
        # 返回单页里的展览地址列表
        return urls


# 解释日期的函数
def getDate(_time_, _sel_):
    ifExistSy = re.findall(u"\d+月\d+日", _time_)
    if (ifExistSy):
        if (len(ifExistSy) == 1):
            try:
                bgyear = re.findall(u"\d+年", _time_)[0][0:-1]
            except:
                bgyear = time.strftime("%Y", time.localtime())
            bgmonth = re.findall(u"\d+月", _time_)[0][0:-1]
            bgday = re.findall(u"\d+日", _time_)[0][0:-1]
            bgDate = '{}.{}.{}'.format(bgyear, bgmonth, bgday)
            enDate = bgDate
            daylist = getDaylist(_sel_)
        elif (len(ifExistSy) == 2):
            try:
                bgyear = re.findall(u"\d+年", _time_)[0][0:-1]
            except:
                bgyear = time.strftime("%Y", time.localtime())
            bgmonth = re.findall(u"\d+月", _time_)[0][0:-1]
            bgday = re.findall(u"\d+日", _time_)[0][0:-1]
            try:
                enyear = re.findall(u"\d+年", _time_)[1][0:-1]
            except:
                enyear = time.strftime("%Y", time.localtime())
            enmonth = re.findall(u"\d+月", _time_)[1][0:-1]
            enday = re.findall(u"\d+日", _time_)[1][0:-1]
            bgDate = '{}.{}.{}'.format(bgyear, bgmonth, bgday)
            enDate = '{}.{}.{}'.format(enyear, enmonth, enday)
            daylist = getDaylist(_sel_)
        elif (len(ifExistSy) >= 2):
            try:
                bgyear = re.findall(u"\d+年", _time_)[0][0:-1]
            except:
                bgyear = time.strftime("%Y", time.localtime())
            bgmonth = re.findall(u"\d+月", _time_)[0][0:-1]
            bgday = re.findall(u"\d+日", _time_)[0][0:-1]
            try:
                enyear = re.findall(u"\d+年", _time_)[-1][0:-1]
            except:
                enyear = time.strftime("%Y", time.localtime())
            enmonth = re.findall(u"\d+月", _time_)[-1][0:-1]
            enday = re.findall(u"\d+日", _time_)[-1][0:-1]
            bgDate = '{}.{}.{}'.format(bgyear, bgmonth, bgday)
            enDate = '{}.{}.{}'.format(enyear, enmonth, enday)
            daylist = []
            for each in ifExistSy:
                daylist.append(each)

    else:
        bgDate = None
        enDate = None
    return bgDate, enDate, daylist


# 有些情况下会有日期列表 此处为获取列表， 便于日历使用
def getDaylist(selector):
    try:
        timelist = selector.xpath('//*[@class="day"]/text()')
        daylist = []
        if (timelist):
            for eachday in timelist:
                y = time.strftime("%Y", time.localtime())
                m = re.search(u"\d+月", eachday).group()[0:-1]
                d = re.search(u"\d+日", eachday).group()[0:-1]
                date_ = '{}.{}.{}'.format(y, m, d)
                daylist.append(date_)
        return daylist
    except:
        return


def storeFile(path, filename, text):
    if (path == ''):
        path = '.'
    fcontent = open("%s/%s" % (path, filename), 'wb')
    fcontent.write(text)
    fcontent.close()


def store_all_file(path):
    all_event = alltext.split(',')
    _text_ = ''
    for eachEvent in all_event:
        event_file = open(path + eachEvent + '.txt', 'rb')
        each_event_content = event_file.readline()
        _text_ += each_event_content
    last_store_file = open(time.strftime("%Y_%m_%d", time.localtime())+'.txt','wb')
    last_store_file.write(_text_)
