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
sql = "INSERT INTO  incomings (id, date, contractor, shop, article, count, sum) \
                                    VALUES (%s, %s, %s, %s, %s, %s, %s)"


with open('2021-22-v2.txt', 'r', encoding='utf-8') as f:
    data = f.read().replace('\xa0', '').split('\n')[8:-2]
    data = [d.split('\t')[1:] for d in data]
    for d in data:
        d[0] = datetime.strptime(d[0], '%d.%m.%Y %H:%M:%S')
        d[-1] = float(d[-1].replace(',','.'))
        d[-2] = float(d[-2].replace(',','.'))
        d.insert(0,str(d[0])+d[1]+d[2]+d[3])

print('start work with db')
val = [tuple(n) for n in data]
n = 1000000
vals = [val[i:i+n] for i in range(0,len(val),n)]
for v in vals:
    mycursor.executemany(sql, v)
    mydb.commit()
    print(mycursor.rowcount, "was inserted.")
