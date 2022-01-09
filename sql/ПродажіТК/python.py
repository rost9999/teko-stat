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
sql = "INSERT INTO  orders (date, shop, article, count) \
                                    VALUES (%s, %s, %s, %s)"


def work(i):
    i = i if type(i) == str else str(i) if i >= 10 else '0'+str(i)
    newdata = []
    with open(i+'.txt', 'r', encoding='utf-8') as f:
        data = f.read().replace('\xa0', '').split('\n')[7:-2]
        data = [d.split('\t')[1:] for d in data]
    for d in data:
        date = datetime.strptime(d[0].split()[0], '%d.%m.%Y')
        mag = d[1]
        article = d[2]
        count = round(float(d[3].replace(' ', '')
                                .replace(',', '.')), 2)
        newdata.append([date, mag, article, count])

    val = [tuple(n) for n in newdata]
    mycursor.executemany(sql, val)
    mydb.commit()
    print(mycursor.rowcount, "was inserted.")

work('00')
for i in range(1,11+1):
    work(i)

print('work done')
