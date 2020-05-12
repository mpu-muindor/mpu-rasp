# API routes list (OLD)

Данная версия спецификации более не поддерживается. Актуальный API описан в [OAS3](RASP_API.yaml)

[URL](https://mpu-muindor.github.io/swagger-api/)

------

| Method | Name                                              | URI                                                | Description                           |
|:-------|:--------------------------------------------------|:---------------------------------------------------|:--------------------------------------|
| GET    | [rasp.suggest](#raspsuggest)                      | /api/rasp/suggest                                  | Возвращает подсказки для поиска       |
| GET    | [rasp.groups.index](#raspgroupsindex)             | /api/rasp/groups                                   | Возвращает список групп               |
| GET    | [rasp.groups.show](#raspgroupsshow)               | /api/rasp/groups/{group:title}                     | Возвращает информацию о группе        |
| GET    | [rasp.groups.lessons](#raspgroupslessons)         | /api/rasp/groups/{group:title}/lessons             | Возвращает расписание группы          |
| GET    | [rasp.professors.index](#raspprofessorsindex)     | /api/rasp/professors                               | Возвращает список преподавателей      |
| GET    | [rasp.professors.show](#raspprofessorsshow)       | /api/rasp/professors/{professor:full_name}         | Возвращает информацию о преподавателе |
| GET    | [rasp.professors.lessons](#raspprofessorslessons) | /api/rasp/professors/{professor:full_name}/lessons | Возвращает расписание преподавателя   |

## Routes 
 
### rasp.suggest

**URI:** `/api/rasp/suggest`

**Request params:**
```
suggest - required, min:2
```
**Response:**
```javascript
response = {
    "groups": [
        {
            "title": string, // Полное название группы
            "completion": string // Дополнение к запросу
        }
    ],
    "professors": [
        {
            "full_name": string, // ФИО преподавателя
            "completion": string // Дополнение к запросу
        }
    ],
    "params": {
        "suggest": string, // Полученный запрос
        "total": { // Всего по запросу найдено
            "groups": int, // групп
            "professors": int // преподавателей
        }
    }
}
```


### rasp.groups.index

**URI:** `/api/rasp/groups/`

**Response:**
``` javascript
response = [
  {
    "title": string, // номер группы,
    "course": int, // Курс
    "evening": bool, // вечерняя группа
    "updated_at": DateTime // Дата время последнего обновления информации о группе и расписания
  }
]
```

### rasp.groups.show

**URI:** `/api/rasp/groups/{group:title}`

**Route params:**
```
{group:title} - номер группы
```

**Response:**
``` javascript
response = {
    "title": string, // номер группы,
    "course": int, // Курс
    "evening": bool, // вечерняя группа
    "updated_at": DateTime // Дата время последнего обновления информации о группе и расписания
}
```

### rasp.groups.lessons

**URI:** `/api/rasp/groups/{group:title}/lessons`

**Request params:**
```
{group:title} - номер группы
```

**Response:**
``` javascript
response = [
    {
        "subject": string, // Название предмета
        "date_from": Date, // Дата начала предмета
        "date_to": Date, // Дата окончания предмета
        "type": string, // Тип занятия
        "day_number": int, // Номер дня недели
        "lesson_number": int, // Номер пары
        "lesson_day": Date || null, // Дата занятия, если занятие не регулярное
        "is_session": bool, // Занятие во время сессии
        "remote_access": string || null, // Ссылка на удаленное занятие, если есть
        "updated_at": DateTime, // Дата последнего обновления информации
        "auditories": [ // Список аудиторий
          {
            "title": string, // Заголовок аудитории
            "color": string || null // Цвет текста
          }
        ],
        "group": { // Информация о группе, у которой пара
            "title": string, // номер группы,
            "course": int, // Курс
            "evening": bool, // вечерняя группа
            "updated_at": DateTime // Дата время последнего обновления информации о группе и расписания
        },
        "professors": [ // Список преподавателей
          {
            "full_name": string, // ФИО преподавателя
            "updated_at": DateTime // Дата последнего обновления информации
          }
        ]
    },
]
```

### rasp.professors.index

**URI:** `/api/rasp/professors`

**Response:**
``` javascript
response = [
      {
        "full_name": string, // ФИО преподавателя
        "updated_at": DateTime // Дата последнего обновления информации
      },
    ]
```

### rasp.professors.show

**URI:** `/api/rasp/professors/{professor:full_name}`

**Route params:**
```
{professor:full_name} - ФИО преподавателя
```

**Response:**
``` javascript
response = {
    "full_name": string, // ФИО преподавателя
    "updated_at": DateTime // Дата последнего обновления информации
  }
```

### rasp.professors.lessons

**URI:** `/api/rasp/professors/{professor:full_name}/lessons`

**Route params:**
```
{professor:full_name} - ФИО преподавателя
```

**Response:**
``` javascript
response = [
    {
        "subject": string, // Название предмета
        "date_from": Date, // Дата начала предмета
        "date_to": Date, // Дата окончания предмета
        "type": string, // Тип занятия
        "day_number": int, // Номер дня недели
        "lesson_number": int, // Номер пары
        "lesson_day": Date || null, // Дата занятия, если занятие не регулярное
        "is_session": bool, // Занятие во время сессии
        "remote_access": string || null, // Ссылка на удаленное занятие, если есть
        "updated_at": DateTime, // Дата последнего обновления информации
        "auditories": [ // Список аудиторий
          {
            "title": string, // Заголовок аудитории
            "color": string || null // Цвет текста
          }
        ],
        "group": { // Информация о группе, у которой пара
            "title": string, // номер группы,
            "course": int, // Курс
            "evening": bool, // вечерняя группа
            "updated_at": DateTime // Дата время последнего обновления информации о группе и расписания
        },
        "professors": [ // Список преподавателей
          {
            "full_name": string, // ФИО преподавателя
            "updated_at": DateTime // Дата последнего обновления информации
          }
        ]
    },
]
```
