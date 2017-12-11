create table tag_article(
    ->    id  int  not null  primary key  auto_increment,
    ->    article_id  int  not null ,
    ->    tag_id  int not null,
    -> foreign  key  fk_article_id(article_id)
    -> references article(id)
    -> on update cascade
    -> on delete set null);

create table tag_article(
id int not null primary  key  auto_increment,
article_id int,
tag_id  int,
 FOREIGN KEY fk_article_id(article_id)
  REFERENCES article(id)
  ON UPDATE CASCADE
  ON DELETE SET NULL
);
ALTER TABLE tag_article
  ADD FOREIGN KEY fk_tag_id(tag_id)
REFERENCES tag(id)
  ON UPDATE CASCADE
  ON DELETE SET NULL;
