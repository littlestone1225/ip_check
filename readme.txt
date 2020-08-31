IP_check====================================
首頁可輸入CIDR格式的IP，並對IP做黑名單檢查。
>>輸入IP：會連線AbuseIPDB做黑名單check，並從使用者黑名單資料庫中檢查是否已輸入，未輸入則新增至使用者黑名單中，若已存在於AbuseIPDB中則不新增(為避免使用者刪除黑名單時刪除到官方資料庫)。
>>輸入CIDR：會連線AbuseIPDB做黑名單check，並檢查使用者黑名單中有無該規則，若無則將此規則存入資料庫中。

刪除黑名單
>>顯示所有使用者輸入的IP，可供選擇刪除。

顯示黑名單
>>列出黑名單，可以button切換顯示模式。

database============================
ip_check.sql

abuseipdb_blacklist
|| num || ipAddress || abuseConfidenceScore||
	
setting
|| index || abuse_LastUpdateTime || user_LastUpdateTime || abuseipdb_TotalIP || user_TotalIP ||

useripdb_blacklist
|| num || ipAddress || mask ||

安裝紀錄================================
GuzzleHttp for API used to link web services.
http://docs.guzzlephp.org/en/stable/overview.html

composer出問題就打: composer install