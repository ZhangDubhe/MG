# coding:utf-8
import Event
import transform
import geocoding
import saveAll
import MySQLdb as mdb
import time
import sys
import os
reload(sys)
sys.setdefaultencoding('utf-8')

# 自动爬取主函数，分成爬取、保存、地理编码、转换再到存入数据库
dirPath = "E:/Code/webget/mg/test/"
timePath = time.strftime("%Y_%m_%d", time.localtime())
txtPath = "E:/Code/webget/mg/save/"+timePath+'/'+"exhibition-origin.txt"
geocodingPath = "E:/Code/webget/mg/save/"+timePath+"/exhibition-g.txt"
transformPath = "E:/Code/webget/mg/save/"+timePath+"/exhibition-t.txt"
def craw(url):
    global dirPath


    eventNum = 10
    N = 0
    for i in range(0, 2, 1):
        print "Now is Page ", i + 1
        p = Event.Page(i * eventNum, url)
        print p.events_links
        for eachurl in p.events_links:
            E = Event.Event(eachurl, dirPath)
            N += 1
            time.sleep(1.5)

        time.sleep(2)

    time.sleep(5)

def createTrain(path):
    # 将con设定为全局连接
    con = mdb.connect('localhost', 'root', 'TFfdVzZrHqDnm89R', 'mg', charset='utf8');
    try:
        with con:
            # 获取连接的cursor，
            cur = con.cursor()

            for line in open(path):
                linelist = line.rstrip('\n').split(',')
                try:
                    cur.execute("INSERT INTO exhibition(eventId,eventUrl,eventName,eventOpentime,eventClosetime,eventBeginDay,eventEndDay,eventAddress,eventPrice,eventImgPath,EventNumInterest,EventNumAttend,eventLon,eventLat,eventStatus,eventLonWGS84,eventLatWGS84)\
                VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                [linelist[0], linelist[1], linelist[2], linelist[3], linelist[4], linelist[5], linelist[6], linelist[7],
linelist[8], linelist[9], linelist[10], linelist[11], linelist[12], linelist[13], linelist[14],
                 linelist[15], linelist[16]])
                    print linelist[0], 'update success'
                except mdb.Error, e:
                    try:
                        cur.execute("UPDATE exhibition SET eventOpentime = %s,eventClosetime = %s,eventBeginDay= %s,eventEndDay= %s,EventNumInterest=%s,EventNumAttend=%s WHERE eventId = %s",
                                    [linelist[3],linelist[4],linelist[5],linelist[6],linelist[10],linelist[11],linelist[0]])
                        print linelist[0],'update success'
                        continue
                    except:
                        print linelist[0],"Update Error"
                    print "Mysql Error %d: %s" % (e.args[0], e.args[1])



    except mdb.Error, e:
        print "Mysql Error %d: %s" % (e.args[0], e.args[1])
        con.close()
        print 'error'
def extra_address():
    newlist = []
    for line in open("exhibition-t.txt"):
        add = line.rstrip('\n').split(',')[7].decode('utf-8')
        try:
            newlist.append(add)
        except:
            print line
    list1 = list(set(newlist))
    w = open("address.txt",'w')
    for each in list1:
        w.write(str(each) + '\r\n')
    w.close()

def main():
    nowFile = "E:/Code/webget/mg/save/"  + timePath + "/"
    if os.path.exists(nowFile):
        pass
    else:
        os.mkdir(nowFile)

    urlist = ["https://shanghai.douban.com/events/future-music",
              "https://shanghai.douban.com/events/future-drama",
              "https://shanghai.douban.com/events/future-salon",
              "https://shanghai.douban.com/events/future-film",
              "https://shanghai.douban.com/events/future-exhibition",
              "https://shanghai.douban.com/events/future-competition"]
    print u'开始爬虫'
    for each in urlist:
        print 10*"-" + each + ' ' + 10*"-"
        #craw(each)
    # craw("https://shanghai.douban.com/events/future-exhibition")
    print u'开始save all'
    saveAll.findall(dirPath, txtPath)
    print u'开始geo'
    geocoding.__init__(txtPath, geocodingPath)
    print u'开始transfer'
    transform.__init__(geocodingPath, transformPath)
    print u'开始 sql'
    createTrain(transformPath)
    extra_address()
    # geocoding.__init__("address.txt","address-g.txt")
    # transform.__init__("address-g.txt","address-t.txt")


if __name__ == '__main__':
    main()