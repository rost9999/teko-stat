import mysql.connector

with open('Помісяцях.txt', 'r', encoding='utf-8') as f:
    data = f.read().replace(' ', '').replace(',','.').split('\n')
    data = [d.split('\t') for d in data]


with open('3торг.txt', 'r', encoding='utf-8') as f:
    group = f.read().replace('Йогурт пляшка 2,2% Злаки-насіння льону	600г','Йогурт пляшка 2,2% Злаки-насіння льону 600г').split('\n')
    group = [g.split('\t')[1:] for g in group]
    for i in range(len(group)):
        if group[i][2] == '':
           group[i][2] = 'немає ТМ' 
        if group[i][4] == '':
            group[i][2] = 'немає 3торг групи'
    group = {g[0]: g[1:] for g in group}


mag = ''
newdata = []

for d in data:
    if d[0].isdigit() is False:
        mag = d[0]
    else:
        mounth = 1
        for d1 in d[1:]:
            newdata.append([d[0], float(d1), mounth, mag]+group[d[0]])
            mounth += 1

print('done')
sql = "INSERT INTO \
    `tekos` (`article`, `count`, `mounth`, `mag`, `name`, `TM`, `grupa`,`torg3`) \
    VALUES (%s,%s,%s,%s,%s,%s,%s,%s)"

val = [tuple(d) for d in newdata]

print('start write to db')
mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="tekopid"
)

n = int(len(val)/10)
manyVal = [val[i:i + n] for i in range(0, len(val), n)]
for val in manyVal:
    mycursor = mydb.cursor()
    mycursor.executemany(sql, val)
    mydb.commit()
    print(mycursor.rowcount, "was inserted.")

print('done2')

