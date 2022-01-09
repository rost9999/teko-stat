from datetime import datetime

import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="teko-trade"
)
mycursor = mydb.cursor()
sql = "INSERT INTO  remainders (shop, article, date, count) \
                                    VALUES (%s, %s, %s, %s)"


def work(i):
    with open(str(i)+'.txt', 'r', encoding='utf-8') as f:
        data = f.read().replace('\xa0', '').split('\n')[:-2]
        data = [d.split('\t')[1:-1] for d in data]
        date = data[5]
        data = data[8:]

    mag = ''
    newdata = []
    for d in data:
        if d[0] != '':
            mag = d[0]
        else:
            article = d[1]
            for i in range(2, len(d)):
                newdate = date[i]
                d[i] = '0' if d[i] == '' else d[i]
                count = round(float(d[i].replace(' ', '')
                                        .replace(',', '.')), 2)
                newdate = datetime.strptime(newdate, '%d.%m.%Y')
                newdata.append([mag, article, newdate, count])


    val = [tuple(n) for n in newdata]
    mycursor.executemany(sql, val)
    mydb.commit()
    print(mycursor.rowcount, "was inserted.")


for i in range(1, 18+1):
    work(i)

print('done')
