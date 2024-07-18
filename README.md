# Canin Educ V2

Connect to mysql:
```sh
sudo mysql
```

Then create database and user:
```sql
CREATE DATABASE canineducateur;
CREATE USER 'canineducateur'@'localhost' IDENTIFIED BY 'ce';
GRANT ALL ON canineducateur.* TO 'canineducateur'@'localhost';
```
