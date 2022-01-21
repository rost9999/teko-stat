import re
import datetime
import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="teko-trade"
)
mycursor = mydb.cursor()
sql = "INSERT INTO  remainders (id, shop, article, date, count) \
                                    VALUES (%s, %s, %s, %s, %s)"


strToDate = datetime.datetime.strptime

with open('last2.txt', 'r', encoding='utf-8') as f:
    datatext = f.read().replace('\xa0', '').replace('\ufeff', '').replace(' ', '')
    data = datatext.split('\n')
    data = [d.split('\t') for d in data]
    alldate = sorted([strToDate(a,'%d.%m.%Y') for a in re.findall(r'\d{2}\.\d{2}\.\d{4}', datatext)])
    for d in data:
        date = re.findall(r'\d{2}\.\d{2}\.\d{4}', d[0])
        if len(date) == 1:
            d[0] = date[0]
            if d[1] == '':
                d[1] = '0'
        if d[0] == '':
          d[0] = str(alldate[0])
          if d[1] == '':
                d[1] = '0'

result = []

countDays = (alldate[-1] - alldate[0]).days + 1
firstDay = alldate[0]
date_list = [firstDay + datetime.timedelta(days=x) for x in range(countDays)]

shop = ''
article = ''
for d in data:
    if re.search(r'[а-яА-я]+', d[0]):
        shop = d[0]
    if d[1] == '':
        article = d[0]
    if re.search(r'\d{2}\.\d{2}\.\d{4}', d[0]):
        date = strToDate(d[0], '%d.%m.%Y')
        count = float(d[1].replace(',', '.'))
        result.append([shop, article, date, count])

newResult = {}
for d in result:
    if d[0] not in newResult:
        newResult[d[0]] = {}
    if d[1] not in newResult[d[0]]:
        newResult[d[0]][d[1]] = {d: '' for d in date_list}
        newResult[d[0]][d[1]][d[2]] = d[3]
    else:
        newResult[d[0]][d[1]][d[2]] = d[3]


def doChange(items, needCount):
    for d in items:
        newResult[d[0]][d[1]][d[2]] = needCount


toChange = []

for shop in newResult:
    for article in newResult[shop]:
        for d in newResult[shop][article]:
            if newResult[shop][article][d] == '':
                toChange.append([shop, article, d])
            else:
                doChange(toChange, newResult[shop][article][d])
                toChange = []
                break

lastCount = ''
for shop in newResult:
    for article in newResult[shop]:
        for d in newResult[shop][article]:
            if newResult[shop][article][d] != '':
                lastCount = newResult[shop][article][d]
            if newResult[shop][article][d] == '':
                newResult[shop][article][d] = lastCount

data = []
for shop in newResult:
    for article in newResult[shop]:
        for d in newResult[shop][article]:
            data.append([shop+article+str(d), shop, article, d, newResult[shop][article][d]])

print('start work with db')
val = [tuple(n) for n in data]
n = 1000000
vals = [val[i:i+n] for i in range(0, len(val), n)]
for v in vals:
 mycursor.executemany(sql, v)
 mydb.commit()
 print(mycursor.rowcount, "was inserted.")
print('work done!')

