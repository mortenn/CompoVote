create table contests (name,hidden integer,opens integer,closes integer);
create table entries (contest,name,contestant);
create table votes (contest,entry,client,key);
create table keys (key,reference,ip);
