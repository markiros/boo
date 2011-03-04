URLs:
    /
    /viewer
    /painter
    
    

Like's count:

    url: http://www.chaskor.ru/article/sem_tajn_kosmosa_21209
    like's info:
        https://api.facebook.com/method/fql.query?query=SELECT%20share_count,%20like_count,%20comment_count,%20total_count%20FROM%20link_stat%20WHERE%20url=%22http://www.chaskor.ru/article/sem_tajn_kosmosa_21209%22
        https://api.facebook.com/method/fql.query?query=SELECT%20share_count,%20like_count,%20comment_count,%20total_count%20FROM%20link_stat%20WHERE%20url=%22http://hmpic.markiros.com/picture/5000/5002%22
        https://api.facebook.com/method/fql.query?query=SELECT count FROM comments_info WHERE app_id="129974973728615"
    
    
    object_id: https://api.facebook.com/method/fql.query?query=SELECT id FROM object_url WHERE url="http://www.chaskor.ru/article/sem_tajn_kosmosa_21209"
    object_id=460368647076
    
    get access token:
    https://graph.facebook.com/oauth/access_token?client_id=142716209076213&client_secret=a04564b36f0eeaaaf37a6612a26a0e5f&grant_type=client_credentials
    -> access_token=142716209076213|6crTK9mx3xXruOt_KP8gBYTqvM0


Получение кол-ва комментариев:
    SELECT count FROM comments_info WHERE app_id=129974973728615 AND xid="hmpic-5000-5002"

Получение постов пользователя uid=879120713:
    https://api.facebook.com/method/fql.query?query=SELECT%20app_id,%20post_id,%20source_id,%20message%20FROM%20stream%20WHERE%20source_id=100001401040213

-------------
Randolik uid=100001401040213
AppId: 129974973728615
Secret: c6e6167a38e0141a94781cee7072cc8c


Step 1 – get access token:
    https://graph.facebook.com/oauth/access_token?client_id=129974973728615&client_secret=c6e6167a38e0141a94781cee7072cc8c&type=client_cred
    -> access_token=129974973728615|x89fSzIb2lWFAuJZMy2UHNCG8n8

Step 2 – Check if access token is working (optional):
    https://graph.facebook.com/129974973728615/subscriptions?access_token=129974973728615|x89fSzIb2lWFAuJZMy2UHNCG8n8
    -> {"data":[]}
    
Step 3 – Submit your update:
    
    curl -k -F 'object=user' 
    -F 'callback_url=http://hmpic.markiros.com/callback/fbupdate' 
    -F 'fields=like' 
    -F 'verify_token=c6e6167a38e0141a94781cee7072cc8c' 
    "https://graph.facebook.com/129974973728615/subscriptions?access_token=129974973728615|x89fSzIb2lWFAuJZMy2UHNCG8n8"

    
    
-------------
Используемые технологии:

    - Amazon S3. Хранение изображений пользователей
    - Amazon EC2. Виртуальный сервер. На нем крутятся:
        - nginx. Веб-сервер. На нем крутятся:
            - MySQL 5.0. База данных. (SimpleDB или MongoDB)
            - MongoDB:
                http://habrahabr.ru/blogs/php/103699/
            - PHP 5.2. Организация фронтенда для Facebook-приложения
                - Zend Framework
                    - Библиотека для работы с S3
                - Rediska - библиотека для работы с Redis
                - jQuery + jQuery UI
                - Facebook API (PHP, JS)
        - Redis. Организация очереди заданий
            http://code.google.com/p/redis/
        - Python 2.6
            - Boto. Библиотека для работы с сервисами Amazon: S3 и SimpleDB:
                http://boto.s3.amazonaws.com/index.html
            - Библиотека для работы с Redis
            - Python Image Library (PIL)
                http://www.pythonware.com/products/pil/
        


1. Пользователь Facebook загружает картинку -> php-обработчик
2. Картинка загружается в S3
3. Создается запись в базе о новой картинке такого то пользователя
4. В очередь добавляется задание на ресайз

TODO:
    - полотно, опера, плавный скроллинг
    - полотно, контекстное меню
    - 



--------------------

Query on users
1. Get the Email IDs of all your friends who use the application

SELECT uid
From User
WHERE is_app_user = 1 AND uid IN (
SELECT uid2
FROM friend
WHERE uid1 = $ user_ID)
2. Get the IDs of all members of a group

SELECT uid
FROM group_member
WHERE gid = $ id_gruppo
Query Pages and Fan Profiles
3. Getting Fan page  administered by a user:

SELECT page_id, name, pic_square
From page
WHERE page_id IN (
SELECT page_id
FROM page_admin
WHERE uid = $ user_ID)
4. Get Fan Pages to the administrator, who have permission to publish:

SELECT page_id, name, pic_square
From page
WHERE page_id IN (
SELECT uid
FROM permissions
WHERE publish_stream = 1 AND uid IN (
SELECT page_id
FROM page_admin
WHERE uid = $ user_ID))
5. Get the Stream of a Fan page (only the content posted by the admin):

To run this query, the user must have given the permission to read the stream on its pages.

SELECT post_id, actor_id, permalink, message, created_time, attachment
FROM Stream
WHERE AND actor_id source_id id_page = $ = $ id_page
6. Get YouTube videos posted on a user’s profile

SELECT attachment
FROM Stream
Filter_key WHERE IN (
SELECT filter_key
FROM stream_filter
WHERE uid = $ user_ID)
AND attachment.caption = ‘www.youtube.com’
7. Get the latest comments from fans to post on a page:

SELECT fromid, time, text, post_id
FROM comment
WHERE post_id IN (
SELECT post_id
FROM Stream
WHERE source_id = $ id_page AND updated_time> $ unix_time)
AND fromid! = $ Id_page
8. Get the latest posts on a fan page:

SELECT post_id, actor_id, permalink, message, created_time, attachment
FROM Stream
WHERE source_id = $ id_pagina AND updated_time> $ unix_time AND actor_id! = Source_id
Queries on Links
9. Get all the links posted on a user’s profile:

SELECT link_id, title, summary, url, image_urls
FROM link
WHERE owner = $ user_ID
10. Get statistics for a link:

SELECT share_count, like_count, comment_count, click_count
FROM link_stat
WHERE url = ‘$ url’


-------------
Flash API:
- Получение баланса пользователя.
    url: http://hmpic.markiros.com/api/balance
    return: { "success":true, "result":1852 }
    
- Получение списка друзей.
    url: http://hmpic.markiros.com/api/friends
    return: { "success":true,"result":[{"uid":"567039819","fullname":"Igor Filippov"},{"uid":"633663751","fullname":"Alexey A. Akhmerov"},{"uid":"879120713","fullname":"Katerina Shishkina" }
    
- Получение списка кистей.
    url: /api/brushes
    
- Покупка кисти: списание денег с баланса, активация кисточки для пользователя.
    url: /api/buy-brush
    
- Отправка пикчи друзьям.
    url: /api/send-to-friends
    
- Отправка пикчи в HMpic. По завершении отправки выводить алерт и предлагать перейти на страничку пикчи.
    url: /api/send
    
- Получение списка друзей для автокомплита. Должно содержать ссылку на автар размером 50*50 (если есть то 30*30).
    url: /api/friends?q=Mark



result = {
    success: true,
    message: 'OK',
    result: [
        { uid: 544667855, fullname: 'Markiros' },
        { uid: 544667855, fullname: 'Markiros' }
    ],
};

result = {
    success: false,
    message: 'Not found',
};

