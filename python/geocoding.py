# -*- coding: utf-8 -*-
import requests
import json
import time

headers = {
    'Accept': "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    'Accept-Encoding': 'gzip, deflate, sdch',
    'Accept-Language': 'zh-CN,zh;q=0.8',
    'Cache-Control': 'max-age=0',
    'Connection': 'keep-alive',
    'Cookie': 'BAIDUID=794E3E65EDAD77AA1C3394F95CDF6A98:FG=1; BIDUPSID=794E3E65EDAD77AA1C3394F95CDF6A98; PSTM=1452320577; BDUSS=VpxbWtXOHozRU1PUW9jZGc1QUZlNHBqWWpLQmNQdDBnamNodHp4UVhuMWpWY1JXQVFBQUFBJCQAAAAAAAAAAAEAAAClmgkHsbTL~su5tcsAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGPInFZjyJxWU; MCITY=-289%3A; H_PS_PSSID=18881_1449_19288_18205_18560_17000_15712_11768_18001_10632_16915',
    'DNT': '1',
    'Host': 'api.map.baidu.com',
    'Upgrade-Insecure-Requests': '1',
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36',

}
app = {
    'appID': '2659366',
    'appName': 'hello',
    'ak': '0RtdF2Ivogp7AvKd7EDRcUPT',
    'output': 'json',
}

url = 'http://api.map.baidu.com/geocoder/v2/'
aks = [
    'lCxSdtESkP6oqvHCGMVeT5CHv51cPTk6',
    'tFFWllGDYYaOSEUoZWPdlr47'
    ]


def makeGeocodingURL(ak, address, city, url='http://api.map.baidu.com/geocoder/v2/', output='json'):
    print url + '?' + ak + '&address=' + address + '&city=' + city + '&output=' + output
    return url + '?ak=' + ak + '&address=' + address + '&city=' + city + '&output=' + output


def getlnglat(address, city, ak):
    url = 'http://api.map.baidu.com/geocoder/v2/'
    output = 'json'
    ak = ak
    uri = url + '?' + 'address=' + address + '&output=' + output + '&city=' + city + '&ak=' + ak
    content = requests.get(uri, headers=headers).content
    return content


def __init__(ori_path, geocode_path):
    aksIter = iter(aks)
    with open(ori_path, 'rb') as f:
        with open(geocode_path,'wb') as g:
            # F:/codes/python/data/dianping_shopping_geocoding.csv
            # t=f.next().rstrip('\r\n')
            # g.write(t+',lng,lat,confidence\n')
            try:
                i = 0
                ak = aksIter.next()
                while True:
                    line = f.next().rstrip('\r\n')
                    try:
                        address = line.split(',')[7].decode('utf-8')
                    except:
                        address = f.next().rstrip('\r\n')
                    # print address
                    result = json.loads(getlnglat(address, u'上海市', ak))
                    if result['status'] != 0:
                        g.write(line + ',None,None,None\r\n')
                        # print "error:", address
                    else:
                        g.write(line + ',' + str(result['result']['location']['lng']) + ',' + str(
                            result['result']['location']['lat']) + ',' + str(result['result']['confidence']) + '\r\n')
                        print line + ',' + str(result['result']['location']['lng']) + ',' + str(
                            result['result']['location']['lat']) + ',' + str(result['result']['confidence'])
                    i += 1
                    time.sleep(0)
                    if i > 5000:
                        ak = aksIter.next()


            except StopIteration, e:
                print 'write over ^_^'

