# coding:utf-8
import requests
from lxml import html
import os
import time
import re
import sys
from bs4 import BeautifulSoup


reload(sys)
sys.setdefaultencoding('utf-8')


class Event:
    EventUrl = []
    EventId = []
    EventName = []
    EventOpentime = []
    EventClosetime = []
    EventBeginDay = []
    EventEndDay = []
    EventAddress = []
    EventPrice = []
    EventContent = []
    EventImgPath = []
    EventDayList = []
    EventNumInterest = []
    EventNumAttend = []
    def addNewEvent(self, url, eId, eName, eOtime, eCtime, eBday, eEday, eAddress, ePrice, eContent, eImgpath, eDaylist, eNI, eNA):
        self.EventUrl.append(url)
        self.EventId.append(eId)
        self.EventName.append(eName)
        self.EventOpentime.append(eOtime)
        self.EventClosetime.append(eCtime)
        self.EventBeginDay.append(eBday)
        self.EventEndDay.append(eEday)
        self.EventAddress.append(eAddress)
        self.EventPrice.append(ePrice)
        self.EventContent.append(eContent)
        self.EventImgPath.append(eImgpath)
        self.EventDayList.append(eDaylist)
        self.EventNumInterest.append(eNI)
        self.EventNumAttend.append(eNA)
    def outEachMsg(self,i):
        line = self.EventId[i] +',' + self.EventUrl[i] +','+self.EventName[i] +','+ self.EventOpentime[i]+','+self.EventClosetime[i]+','+self.EventBeginDay[i]+','+ self.EventEndDay[i]+','+self.EventAddress[i]+','+self.EventPrice[i]+','+self.EventImgPath[i]+','+str(self.EventNumInterest[i])+','+str(self.EventNumAttend[i])
        return line


e1 = Event()


#获取总共页码
def getPage(url):
    baseUrl = url
    selector = html.fromstring(requests.get(baseUrl).content)

    try:
        pageNum = selector.xpath('//*[@id="db-events-list"]/div[2]/a[6]/text()')[-1]
    except:
        pageNum = 10
    return int(pageNum)


# 获取主页列表
def getUrl(url):
    baseUrl = url
    selector = html.fromstring(requests.get(baseUrl).content)
    urls = []
    for i in selector.xpath('//*[@id="db-events-list"]/ul/li/div[1]/a/@href'):
        urls.append(i)
    # 返回单页里的展览地址列表
    return urls



# 获取内容详情
def getPiclink(url):

    page = requests.get(url).content
    sel = html.fromstring(page)
    #获取各字段
    #id
    eid = re.search("/\d+/", url).group()[1:-1]
    #展览名
    ename = str(sel.xpath('//*[@id="event-info"]/div[1]/h1/text()')[0].decode('utf-8')).strip().replace('\n','')
    timestr = sel.xpath('//*[@id="event-info"]/div[1]/div[1]/ul/li/text()')[0].decode('utf-8')

    # 调用获取日期函数
    bgDate, enDate, daylist = getDate(timestr, sel)



    ifExistTime = re.search(u":", timestr)
    if(ifExistTime):
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


    # 单张图片展示 图片url地址
    eImgpath = sel.xpath('//*[@id="poster_img"]/@src')[0].decode('utf-8')

    # 展览地址
    try:
        eAddress = sel.xpath('//*[@id="event-info"]/div[1]/div[2]/span[2]/span[3]/text()')[0].decode('utf-8')
    except:
        eAddress = sel.xpath('//*[@id="event-info"]/div[1]/div[2]/span[2]/span[2]/text()')[0].decode("utf-8")
    # 展览票价
    ePrice = sel.xpath('//*[@id="event-info"]/div[1]/div[3]/text()')[1].decode('utf-8').strip().replace('\n','')

    # 感兴趣人数
    eNumInterest = sel.xpath('//*[@id="event-info"]/div[1]/div[6]/span[1]/text()')[0]

    #要参加人数
    eNumAttenting = sel.xpath('//*[@id="event-info"]/div[1]/div[6]/span[3]/text()')[0]

    print u"爬取：", ename.decode('utf-8')

    #沉睡5s 开始获取详情介绍 获取整个html代码 插入进主页里
    time.sleep(0.5)
    # page = urllib2.urlopen(url)
    soup = BeautifulSoup(page, 'lxml')
    # 详情的代码块
    eContent = str(soup.find(id='link-report').prettify())

    # 将一个展览中的各字段导入进对象e1中，序号为N, 字段中加上N为该内容
    e1.addNewEvent(url, eid, ename, opTime, clTime, bgDate, enDate, eAddress, ePrice, eContent, eImgpath, daylist, eNumInterest, eNumAttenting)

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
    fcontent = open("%s/%s" %(path, filename), 'wb')
    fcontent.write(text)
    fcontent.close()

def storeEvent(n):
    print 20*'-'+"SAVING"+20*'-'
    text = ''
    for i in range(0, n, 1):

        # 注意回车符号
        text = text + e1.outEachMsg(i) +'\r\n'

        # 保存较难保存的内容
        dirName = './/'+str(e1.EventId[i])
        if(os.path.exists(dirName)):
            storeFile(dirName, '//content.txt', e1.EventContent[i])
        else:
            # 新建文件夹
            os.mkdir(dirName)
            storeFile(dirName, '//content.txt', e1.EventContent[i])
        if(e1.EventDayList):
            list = ''
            for each in e1.EventDayList[i]:
                list = list + each + ','
            storeFile(dirName,'//daylist.txt', list[0:-1])
    path = time.strftime("%Y_%m_%d", time.localtime()) + '.txt'
    file = open(path, "wb")
    file.write(text)
    file.close()
    print u'保存结束'

def crawEvent():
    print u'开始爬虫'
    eventNum = 10
    originalUrl = 'https://shanghai.douban.com/events/future-all'
    pageNum = getPage(originalUrl)
    N = 0
    for i in range(0, pageNum, 1):
        print "Now is Page ", i+1
        pNum = str(i*eventNum)
        url = originalUrl + '?start=' + pNum
        for link in getUrl(url):
            print 'Now is scrawling: ', link
            getPiclink(link)
            N += 1
            time.sleep(1)

        time.sleep(2)
    storeEvent(N)
    time.sleep(10)


#在这里加上其他函数 比如定时
def main():
    crawEvent()
    #开始爬虫


if __name__ == '__main__':
    main()

