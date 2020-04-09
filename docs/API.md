# API routes

| Type | Route                                | Options                   | Description                     |
|:-----|:-------------------------------------|:--------------------------|:--------------------------------|
| GET  | [/api/rasp/suggest](#apiraspsuggest) | suggest - required, min:2 | Возвращает подсказки для поиска |


### /api/rasp/suggest

```
Request:
    suggest - required, min:2
Response:
    {
        "groups": [
            {
                "title": "Полное название группы",
                "completion": "Дополнение к запросу"
            }
        ],
        "professors": [
            {
            "full_name": "ФИО преподавателя",
            "completion": "Дополнение к запросу"
            }
        ],
        "params": {
            "suggest": "Полученный запрос",
            "total": { // Всего по запросу найдено
                "groups": 1, // групп
                "professors": 1 // преподавателей
            }
        }
    }
    
```

