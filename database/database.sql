show databases;

use personal_blog;
create database personal_blog;
show tables;
select * from users;
select * from addresses;
select * from social_media;
select * from tags;
select * from categories;
select * from oauth_access_tokens;
select * from oauth_personal_access_clients;
select * from oauth_refresh_tokens;
select * from oauth_auth_codes;
select * from oauth_clients;

delete from users where id = 1; 
drop table users;
drop table posts;
drop table post_tag;
drop table media;
drop table likes;
drop table auth_codes;
drop table categories;

drop database personal_blog;