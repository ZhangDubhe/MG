# -*- coding: UTF-8 -*-
import MySQLdb as mdb
import time
start = time.time()
def createTrain():
    try:
        #将con设定为全局连接
        con = mdb.connect('139.224.8.209', 'qianjl', 'qjl1996127','mg',charset='utf8');#
        with con:
            #获取连接的cursor，
            cur = con.cursor()
            #创建一个数据表 writers(id,name)
            # cur.execute("DROP TABLE IF EXISTS exhibition")
            #cur.execute("set names 'utf8'")
##            f=open('D:\\python\\exhibition\\2017_04_14.txt','rb')
##            s=f.read()
##            for line in s:
##                linelist = line.split(',')

            
            for line in open("D:\\python\\exhibition\\2017_04_14.txt"):
                linelist = line.split(',')
                cur.execute("INSERT INTO exhibition(eventId,eventUrl,eventName,\
                eventOpentime,eventClosetime,eventBeginDay,eventEndDay,eventAddress,eventPrice,eventImgPath,EventNumInterest,EventNumAttend,content)\
                VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)", [linelist[0], linelist[1], linelist[2], linelist[3],linelist[4],linelist[5],linelist[6],linelist[7], linelist[8], linelist[9],linelist[10], linelist[11]])
            print 'true'
    # except mdb.Error,e:
    
    #     print 'error'
        # print "Mysql Error %d: %s" % (e.args[0], e.args[1])
        # con.close()
    except mdb.Error, e:
        print "Mysql Error %d: %s" % (e.args[0], e.args[1])
        con.close()
        print 'error'
createTrain()
print 'total running: ', time.time()-start
print 'done'
