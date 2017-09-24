/*
EVERY WEEK YOU HAVE TO RUN THIW QUERY AND TO GIVE A PRIZE TO THE WINER, THEN ADD THE WINER IN THE TXT FILE

*/

SELECT UserID, (SELECT COUNT(*) FROM PS_GameLog.dbo.ActionLog WHERE ActionType = 103 AND UserID = B.UserID AND ActionTime between GETDATE() - 9999 and GETDATE()) as Count
FROM PS_GameLog.dbo.ActionLog AS B
WHERE ActionType = 103 AND ActionTime between GETDATE() - 7 and GETDATE()
GROUP BY UserID ORDER BY Count DESC

