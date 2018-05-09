# -*- coding: utf-8 -*-
import requests
import sys


reload(sys)
sys.setdefaultencoding('utf-8')


def requestCmaDataApi(url, timePeriod,statList,orderList):
    '''

    :param url: api的url地址
    :param timePeriod: 需求的时间序列
    :param statList:  需求的站点序列
    :param orderList: 需求的数据序列
    :return: 所有数据
    '''
    requestUrl = url
    userId = "500883449481rVr27"
    userPwd = "fnCXHJ9"
    elementsList = ["Station_Id_C", "Year", "Mon", "Day", "Hour", orderList]
    tList = []
    for each in timePeriod:
        tList.append(str(each))
    timePeriod = "[" + ",".join(tList) + "]"
    statList = ",".join(statList)
    elementsList = ",".join(elementsList)

    options = {"userId": userId,
               "pwd": userPwd,
               "dataFormat": "json",
               "interfaceId": "getSurfEleByTimeRangeAndStaID",
               "dataCode": "SURF_CHN_MUL_HOR",
               "timeRange": timePeriod,
               "staIDs": statList,
               "elements": elementsList}
    res = requests.get(requestUrl, params=options)
    if res.status_code == 200:
        try:
            json = res.json()
        except:
            print res
            return None
        count = json.get('rowCount')
        returnCode = json.get('returnCode')
        c = 0
        if returnCode == '0' and count >= 1:
            fieldNames = json.get('fieldNames')
            fieldUnits = json.get('fieldUnits')
            print count + '-' + fieldNames
            data = json.get("DS")
            output = 'statId_C,Year,Mon,Day,Hour,' + orderList + fieldUnits + '\n'
            if(',' in orderList):
                order = orderList.split(',')
                orderLen = len(order)
            else:
                order = [orderList]
                orderLen = 1
            for each in data:
                datum = each
                statId_C = datum.get('Station_Id_C')
                Year = datum.get('Year')
                Mon = datum.get('Mon')
                Day = datum.get('Day')
                Hour = datum.get('Hour')
                single = statId_C + ',' + Year + ',' + Mon + ',' + Hour + ',' + Day
                for o in order:
                    single += ',' + datum.get(o)
                output += single + '\n'
            return output
        else:
            return None
    else:
        return None


def store_all(text, filename):
    _path = filename
    _file = open(_path, "wb")
    _file.write(text)
    _file.close()

def main():
    requestUrl = "http://api.data.cma.cn:8090/api"
    timePeriod = [20170720030000, 20170724030000]
    statList = ["54511", "54512"]
    out = requestCmaDataApi(requestUrl, timePeriod=timePeriod, statList=statList, orderList="TEM,PRS_Sea,PRE_1h")
    store_all(out, "data.txt")

if __name__ == '__main__':
    main()



