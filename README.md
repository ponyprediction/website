# PonyPrediction - Website

Website for PonyPrediction. This is a work in progress. 

## Database

The website works with a MySQL database.

The default configuration is as follow : 
* Database :  ponyprediction
* User :      ponyprediction
* Password :  pass

To fill the database you can use the following command :
```{r, engine='bash', count_lines}
mysql -u USERNAME -p DATABASE < PATH_TO_WEBSITE/mysql/text.sql
```
