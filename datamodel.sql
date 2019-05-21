create table parkings
(
  id          smallint(5) unsigned auto_increment
    primary key,
  name        varchar(40)   not null,
  price       decimal(50,2) null,
  lat         decimal(10,8) null,
  lng         decimal(11,8) null,
  imglink     varchar(100)  null,
  description varchar(1000) null,
  vidlink     varchar(100)  null
);

create table reviews
(
  id          smallint(5) unsigned auto_increment
    primary key,
  p_id        smallint(5) unsigned not null,
  value       smallint(5) unsigned not null,
  customer    varchar(20)          null,
  description varchar(1000)        null,
  constraint fk_reviews
    foreign key (p_id) references parkings (id)
      on delete cascade
);

create table users
(
  id           smallint(6) auto_increment
    primary key,
  name         varchar(50)                                                                       not null,
  email        varchar(50)                                                                       not null,
  dateofbirth  date                                                                              not null,
  bio          varchar(200)                                                                      not null,
  type         enum ('owner', 'driver')                                                          not null,
  referredBy   enum ('Word of Mouth', 'Google', 'Bing', 'Online Ad', 'Social Media', 'Referral') null,
  username     varchar(70)                                                                       null,
  salt         varchar(70)                                                                       null,
  passwordhash varchar(300)                                                                      null,
  constraint users_username_uindex
    unique (username)
);

