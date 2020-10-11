import json
import mysql.connector
import datetime
import requests
import time

mydb = mysql.connector.connect(host = "localhost",user = "root",passwd = "",database = "wowah")
mycursor = mydb.cursor()
sql = """CREATE TABLE IF NOT EXISTS `record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tab_name` varchar(80) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
"""
mycursor.execute(sql)
sql = "SELECT * FROM record ORDER BY id DESC LIMIT 1"
mycursor.execute(sql)
myresult = mycursor.fetchall()
timeCon = time.time() - myresult[0][2]


def startinput():
	r = requests.get('http://api.tradeskillmaster.com/v1/item/EU/sylvanas?format=json&apiKey=UNqSp-NI5heP5ZXmhB9a6csoa371QysO')
	str = r.json()
	x = datetime.datetime.now()
	tbname = x.strftime("%X-%x")

	sql = """CREATE TABLE `wowah`.`{}` (`item_id` INT(11), `item_name` VARCHAR(255), `item_level` INT(11),
`item_class` VARCHAR(255), `item_subclass` VARCHAR(255), `item_vendorbuy` INT(11),
`item_vendorsell` INT(11), `item_marketvalue` INT(11), `item_minbuyout` INT(11),
`item_quantity` INT(11), `item_numauctions` INT(11), `item_historicalprice` INT(11),
`item_regmarketavg` INT(11), `item_regminbuyavg` INT(11), `item_regquantity` INT(11),
`item_histprice` INT(11), `item_regsaleavg` INT(11), `item_regavgdailysold` INT(11),
`item_regsalerate` INT(11));""".format(tbname)


	mycursor.execute(sql)
	
	sql = "INSERT INTO record (tab_name, created_on) VALUES (%s, %s);"
	val = (tbname, time.time())
	mycursor.execute(sql, val)

	sql = """INSERT INTO  `wowah` . `{}` (item_id, item_name, item_level, item_class, item_subclass, item_vendorbuy, item_vendorsell,
			item_marketvalue, item_minbuyout, item_quantity, item_numauctions, item_historicalprice, item_regmarketavg, 
			item_regminbuyavg, item_regquantity, item_histprice, item_regsaleavg, item_regavgdailysold, item_regsalerate)
			VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)""".format(tbname)



	
	num = 0
	for x in str:
		val = (str[num]["Id"], str[num]["Name"], str[num]["Level"], str[num]["Class"], str[num]["SubClass"], str[num]["VendorBuy"], 
	str[num]["VendorSell"], str[num]["MarketValue"], str[num]["MinBuyout"], str[num]["Quantity"], str[num]["NumAuctions"], 
	str[num]["HistoricalPrice"], str[num]["RegionMarketAvg"], str[num]["RegionMinBuyoutAvg"], str[num]["RegionQuantity"], 
	str[num]["RegionHistoricalPrice"], str[num]["RegionSaleAvg"], str[num]["RegionAvgDailySold"], str[num]["RegionSaleRate"])
	
	
		mycursor.execute(sql, val)
		mydb.commit()
		print(mycursor.rowcount, "record inserted.")
		num = num + 1
	print("Input finished")


if(timeCon > 3600):
	startinput()
else:
	print("Its too soon. Try again after: ", 3600 - timeCon , "seconds.")