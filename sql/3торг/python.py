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
sql = "INSERT INTO  torg3 (article, name, tm, groupTT, torg3) \
                                    VALUES (%s, %s, %s, %s, %s)"

with open('3торг.txt', 'r', encoding='utf-8') as f:
    data = f.read().split('\n')
    data = [d.split('\t') for d in data]
newdata = []
for d in data:
    if d[1] == '':
        d[1] = 'Без назви'
    if d[2] == '':
        d[2] = 'Без ТМ'
    if d[3] == '':
        d[3] = 'Без Групи'
    if d[4] == '':
        d[4] = 'Без 3-Торг'
    newdata.append(d)
        

print('start work with db')
val = [tuple(n) for n in newdata]
mycursor.executemany(sql, val)
mydb.commit()
print(mycursor.rowcount, "was inserted.")
print('work done')
