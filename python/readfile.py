# -*- coding: utf-8-*-
f=open("origin3.txt",'r')

a= [ [0 for i in range(7)] for m in range(46)]
i=0
m=0
flag=0
text=[]
for each in f:
    print each,
    if(flag==0):
        if("博物馆" in each):
            a[m][0]=each.split('、')[0]
            a[m][1]=each.split('、')[1]
            i=2
            flag=2
            print each
        elif("科技馆"in each or "科普" in each or "自然" in each):
            a[m][0]=each.split('、')[0]
            a[m][1]=each.split('、')[1]
            i=2
            flag=2
        elif("美术馆" in each):
            a[m][0]=each.split('、')[0]
            a[m][1]=each.split('、')[1]
            i=2
            flag=2
        elif("展示馆" in each):
            a[m][0]=each.split('、')[0]
            a[m][1]=each.split('、')[1]
            i=2
            flag=2
        elif("馆" in each ):
            a[m][0]=each.split('、')[0]
            a[m][1]=each.split('、')[1]
            i=2
            flag=2
        elif("楼" in each ):
            a[m][0]=each.split('、')[0]
            a[m][1]=each.split('、')[1]
            i=2
            flag=2
    if(flag==2 or flag==1):
        if("地址"in each):
            a[m][2]=each.split("：")[1]
            flag=1
        elif("票价"in each or "门票" in each):
            a[m][3]=each[5:-1]
            flag=1
        elif("开放时间"in each):
            text=each[9:-1]
            a[m][4]=text
            flag=1
        elif("电话"in each):
            a[m][5]=each.split("：")[1]
            flag=1
        elif("://"in each):
            a[m][6]=each
            flag=1

    if(each=="\n"):
        m=m+1
        i=0
        flag=0
        print a[m-1][0],a[m-1][1],a[m-1][3],a[m-1][4]
        
    if(each=="\r\n"):
        m=m+1
        i=0
        flag=0
        print a[m-1][0],a[m-1][1],a[m-1][3],a[m-1][4]

    
f.close()
fw=open("daquan2.txt",'w')

for m in range(45):
    fw.write("\'")
    for i in range(7):
        fw.write(str(a[m][i]))
        if(i==6):            
            fw.write("\'")
            break
        fw.write("\',\'")
    fw.write("\r\n")
fw.close()
