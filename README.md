# FeedYaNews
Для яндекс-новости формирует RSS канал с полями для яндекса.
Все работает по образу и подобию штатного Feed от ZF3.
Убраны не нужные расширения и устаревший менеджер

Требования к ленте https://yandex.ru/support/news/feed.html

Установка composer require masterflash-ru/feed-yanews

пример использования:
```php
use Mf\FeedYaNews\Writer\Feed;

        $feed = new Feed;
        $feed->setTitle("автопортал За рулем Кубань");
        $feed->setLanguage('ru');

        $feed->setDescription("Новости");
        $feed->setLink('https://zrkuban.ru'); 
        $feed->addAuthor([
            'name'  => 'Иванов Иван',
            'email' => 'paddy@example.com',
            'uri'   => 'https://zrkuban.ru',
        ]);
        
        //Если нужно учитывать и часовой пояс, то задавать дату можно только так
        //если передавать время в виде целого числа, то пояс не будет учитываться
        $feed->setDateModified(new \DateTime("2019-09-08 0:39:23"));
        
        //логотип
        $feed->setImage([
            "uri"=>"https://www.zrkuban.ru/App/View/images/logo_100_100.jpg",
            "title" =>"автопортал За рулем Кубань",
            "link"=>"https://zrkuban.ru"
        ]);


        $entry = $feed->createEntry();
        $entry->setTitle('Заголовок статьи');
        $entry->setLink('http://www.example.com/all-your-base-are-belong-to-us');
        $entry->setPdaLink('http://M.example.com/MOBILA');
        $entry->setAmpLink('http://AMP.example.com/MOBILA');
        $entry->setGenre("article");
        
        $entry->addAuthor([
            'name'  => 'Paddy',
            'email' => 'paddy@example.com',
            'uri'   => 'http://www.example.com',
        ]);
        
        $entry->setDateCreated(time());
        
        //раздел, например, новости
        $entry->addCategory([
                    'term'=>"news",
                ]);
        
        //медиафайлы, можно прикреплять множество
        $entry->addEnclosure([
            "uri"=>"https://www.zrkuban.ru/App/View/images/logo_100_100.jpg",
            "type"=>"image/jpeg",
            "length"=>"12345"
        ]);
        $entry->addEnclosure([
            "uri"=>"https://www.zrkuban.ru/App/View/images/logo_100_100.jpg",
            "type"=>"image/jpeg",
            "length"=>"54321"
        ]);
        
        $entry->setDescription('Анонс статьи ');
        $entry->setContent(
            'Подробно статья Подробно статья Подробно статья Подробно статья Подробно статья '
        );
        
        //добавить в ленту элемент статьи
        $feed->addEntry($entry);
        
        //вывод в XML, заголовки в ответ сервера не добавляются
        echo $feed->export();
```
