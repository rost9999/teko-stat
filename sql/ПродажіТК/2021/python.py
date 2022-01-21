# import re
from datetime import datetime
import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="teko-trade"
)
mycursor = mydb.cursor()
sql = "INSERT INTO  orders (date, shop, article, count, sum) \
                                    VALUES (%s, %s, %s, %s, %s)"


def work(name):
##    i = i if type(i) == str else str(i) if i >= 10 else '0'+str(i)
    newdata = []
    with open(name+'.txt', 'r', encoding='utf-8') as f:
        data = f.read().replace('\xa0', '').split('\n')[7:-2]
        data = [d.split('\t')[1:] for d in data]
    for d in data:
        date = datetime.strptime(d[0].split()[0], '%d.%m.%Y')
        mag = d[1]
        article = d[2]
        count = round(float(d[3].replace(' ', '')
                                .replace(',', '.')), 2)
        d[4] = '0' if d[4] == '' else d[4]
        summ = round(float(d[4].replace(' ', '')
                                .replace(',', '.')), 2)
        newdata.append([date, mag, article, count, summ])

    val = [tuple(n) for n in newdata]
    mycursor.executemany(sql, val)
    mydb.commit()
    print(mycursor.rowcount, "was inserted.")

work('19-20.01.2021')
##for i in range(1,12+1):
##    work(i)
    

print('work done')
