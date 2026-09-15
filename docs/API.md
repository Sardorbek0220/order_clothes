# Order App — Mobile API

## Umumiy

**Base URL:** `http://<server>/api` (lokal: `http://127.0.0.1:8000/api`)

**Har bir so'rovda yuboriladigan headerlar:**

```
Accept: application/json
Content-Type: application/json
```

`Accept: application/json` yuborilmasa, xatolik bo'lganda server JSON o'rniga HTML sahifa qaytarishi mumkin.

**Token.** `register` va `login` javobida `token` qaytadi. Uni saqlab qo'ying va keyinchalik himoyalangan so'rovlarda shunday yuboring:

```
Authorization: Bearer 1|Xk9c2Qm...
```

> Hozircha hech bir endpoint token talab qilmaydi, lekin tokenni saqlab boring — keyin kerak bo'ladi.

**Ma'lumot turlari:**

| Maydon turi | JSON'da | Misol |
|---|---|---|
| `id`, `*_id`, `price` | number (butun) | `15` |
| `uid`, `user_uid` | string | `"15"` |
| Summa/og'irlik (`total_summa`, `summa`, `weight`, `amount`) | **string** | `"174000.00"` |
| `lat`, `lon` | number (float) | `61.3243` |
| Sana (`created_at`, `updated_at`) | string, ISO 8601, UTC | `"2023-02-24T05:58:45.000000Z"` |

**Validatsiya xatolari** (`register`, `login`) — `422`, xabarlar ingliz tilida:

```json
{
  "success": false,
  "errors": {
    "phone": ["The phone has already been taken."],
    "password": ["The password confirmation does not match."]
  }
}
```

---

## Endpointlar ro'yxati

| Method | URL | Vazifasi |
|---|---|---|
| POST | `/register` | Telefon + parol bilan ro'yxatdan o'tish |
| POST | `/login` | Telefon + parol bilan kirish |
| GET | `/` | Xizmatlar, kategoriyalar, buyurtma statuslari |
| GET | `/create_order` | Buyurtma yaratish |
| GET | `/orders` | Foydalanuvchi buyurtmalari |
| GET | `/order_update` | Buyurtmani yangilash (**hozir ishlamaydi**) |
| POST | `/before_register` | SMS kod yuborish |
| POST | `/after_register` | SMS kodni tasdiqlash |

---

## 1. Ro'yxatdan o'tish

`POST /api/register`

### Request body

| Maydon | Tur | Majburiy | Qoida |
|---|---|---|---|
| `phone` | string | ha | max 50 belgi, bazada takrorlanmasligi kerak |
| `address` | string | ha | max 1000 belgi |
| `password` | string | ha | kamida 6 belgi |
| `password_confirmation` | string | ha | `password` bilan bir xil bo'lishi kerak |
| `name` | string | yo'q | yuborilmasa bo'sh satr saqlanadi |

```json
{
  "phone": "998901234567",
  "address": "Toshkent, Yunusobod 3/4/31",
  "password": "secret123",
  "password_confirmation": "secret123",
  "name": "Ali"
}
```

### Response `201 Created`

```json
{
  "success": true,
  "data": {
    "user": {
      "id": 15,
      "uid": "15",
      "name": "Ali",
      "address": "Toshkent, Yunusobod 3/4/31",
      "phone": "998901234567",
      "user_type_id": 5,
      "status_id": 1,
      "created_at": "2026-09-15T10:00:00.000000Z",
      "updated_at": "2026-09-15T10:00:00.000000Z"
    },
    "token": "1|Xk9c2QmR7aLpT0vWn3sYbJ8eHfUdKiGo4zCxMqNl"
  }
}
```

`user.uid` — buyurtmalar bilan ishlashda (`create_order`, `orders`) shu qiymat yuboriladi.

### Xatolar

| Status | Holat |
|---|---|
| `422` | Validatsiya xatosi (telefon band, parollar mos emas, parol qisqa va h.k.) |

---

## 2. Kirish

`POST /api/login`

### Request body

| Maydon | Tur | Majburiy |
|---|---|---|
| `phone` | string | ha |
| `password` | string | ha |

```json
{
  "phone": "998901234567",
  "password": "secret123"
}
```

### Response `200 OK`

```json
{
  "success": true,
  "data": {
    "user": {
      "id": 15,
      "uid": "15",
      "name": "Ali",
      "email": null,
      "address": "Toshkent, Yunusobod 3/4/31",
      "phone": "998901234567",
      "region_id": null,
      "district_id": null,
      "user_type_id": 5,
      "status_id": 1,
      "random_number": null,
      "created_at": "2026-09-15T10:00:00.000000Z",
      "updated_at": "2026-09-15T10:00:00.000000Z"
    },
    "token": "2|Pq7wErTy8uIoAs5dFgHj6kLzXc3vBnM9qWe1rTyU"
  }
}
```

### Xatolar

| Status | Body |
|---|---|
| `401` | `{"success": false, "message": "Telefon raqam yoki parol noto'g'ri"}` |
| `403` | `{"success": false, "message": "Foydalanuvchi faol emas"}` |
| `422` | Validatsiya xatosi |

---

## 3. Boshlang'ich ma'lumotlar

`GET /api/`

Request body yo'q.

### Response `200 OK`

```json
{
  "services": [
    {
      "id": 1,
      "name": "Xizmat nomi",
      "name_ru": "Название услуги",
      "name_en": "Service name",
      "photo": "images/2023-02-25/HYqSDFtZ6RWOIzmxuLxLJIyCNT8LXBSaVAZRXoTe.jpg",
      "price": 15000,
      "service_cat_id": 1,
      "status_id": 1,
      "created_at": "2023-02-11T13:15:09.000000Z",
      "updated_at": "2023-02-25T10:43:53.000000Z"
    }
  ],
  "service_categories": [
    {
      "id": 1,
      "name": "Kategoriya",
      "name_ru": "Категория",
      "name_en": "Category",
      "photo": "images/2023-02-25/XTzTZ9nUWWqbWZNTPGDdfSelWRMLDzhTo1bZjzjm.jpg",
      "status_id": 1,
      "created_at": "2023-02-10T14:41:19.000000Z",
      "updated_at": "2023-03-04T09:43:43.000000Z"
    }
  ],
  "order_statuses": [
    { "id": 1, "name": "yangi", "name_ru": "новый", "name_en": "new" },
    { "id": 2, "name": "jarayonda", "name_ru": "в ходе выполнения", "name_en": "in progress" },
    { "id": 3, "name": "bajarildi", "name_ru": "сделанный", "name_en": "done" },
    { "id": 4, "name": "yuborildi", "name_ru": "отправил", "name_en": "sent" },
    { "id": 5, "name": "yetkazildi", "name_ru": "доставленный", "name_en": "delivered" },
    { "id": 6, "name": "bekor qilindi", "name_ru": "отменен", "name_en": "canceled" }
  ]
}
```

- `photo` — nisbiy yo'l, `null` bo'lishi mumkin. To'liq URL uchun server manzilini backenddan aniqlang.
- Ro'yxat **barcha** yozuvlarni qaytaradi, `status_id` bo'yicha filtrlanmagan.
- Buyurtma holatini ko'rsatishda `order_statuses` dan foydalaning (`order.order_status_id` → `order_statuses[].id`).

---

## 4. Buyurtma yaratish

`GET /api/create_order`

> Method **GET** — ma'lumotlar query parametr sifatida yuboriladi. `orders` massivi `orders[0][summa]=...` ko'rinishida beriladi.

### Query parametrlar

| Parametr | Tur | Majburiy | Izoh |
|---|---|---|---|
| `uid` | string | ha | `user.uid` |
| `total_summa` | number | ha | |
| `total_weight` | number | ha | |
| `address` | string | yo'q | |
| `lat` | number | yo'q | |
| `lon` | number | yo'q | |
| `phone` | string | yo'q | |
| `orders` | array | ha | kamida bitta element |
| `orders[i][summa]` | number | ha | |
| `orders[i][weight]` | number | ha | |
| `orders[i][service_id]` | integer | ha | `services[].id` |
| `orders[i][service_cat_id]` | integer | ha | `service_categories[].id` |

### Misol

```
GET /api/create_order?uid=15&total_summa=174000&total_weight=45&address=Toshkent%2C%20Yunusobod%203%2F4%2F31&lat=41.3243&lon=69.2879&phone=998901234567&orders[0][summa]=58000&orders[0][weight]=15&orders[0][service_id]=3&orders[0][service_cat_id]=4&orders[1][summa]=116000&orders[1][weight]=30&orders[1][service_id]=1&orders[1][service_cat_id]=1
```

Mantiqan bir xil ma'lumot (JSON ko'rinishida):

```json
{
  "uid": "15",
  "total_summa": 174000,
  "total_weight": 45,
  "address": "Toshkent, Yunusobod 3/4/31",
  "lat": 41.3243,
  "lon": 69.2879,
  "phone": "998901234567",
  "orders": [
    { "summa": 58000, "weight": 15, "service_id": 3, "service_cat_id": 4 },
    { "summa": 116000, "weight": 30, "service_id": 1, "service_cat_id": 1 }
  ]
}
```

### Response `200 OK`

```json
true
```

Yangi buyurtma `order_status_id = 1` (yangi) bilan yaratiladi. Javobda buyurtma `id` si qaytmaydi — kerak bo'lsa `/orders` dan oling.

### Xatolar

Server tomonda validatsiya yo'q. Majburiy maydon tushib qolsa yoki `orders` yuborilmasa — `500`.

---

## 5. Buyurtmalar ro'yxati

`GET /api/orders?uid=15`

### Query parametrlar

| Parametr | Tur | Majburiy |
|---|---|---|
| `uid` | string | ha |

### Response `200 OK`

Buyurtmalar massivi. Buyurtma bo'lmasa — `[]`.

```json
[
  {
    "id": 3,
    "user_uid": "15",
    "total_summa": "174000.00",
    "total_weight": "45.00",
    "address": "Toshkent, Yunusobod 3/4/31",
    "lat": 41.3243,
    "lon": 69.2879,
    "phone": "998901234567",
    "order_status_id": 4,
    "updated_by": 3,
    "created_at": "2023-02-24T05:58:45.000000Z",
    "updated_at": "2023-03-17T06:57:56.000000Z",
    "order_details": [
      {
        "id": 4,
        "order_id": 3,
        "summa": "58000.00",
        "weight": "15.00",
        "service_id": 3,
        "service_cat_id": 4,
        "created_at": "2023-02-24T05:58:45.000000Z",
        "updated_at": "2023-02-24T05:58:45.000000Z"
      }
    ],
    "payments": [
      {
        "order_id": 3,
        "amount": "15000.00",
        "updated_at": "2023-10-17T18:16:33.000000Z"
      }
    ]
  }
]
```

- `payments` — faqat muvaffaqiyatli to'lovlar. To'lanmagan bo'lsa `[]`.
- `total_summa`, `summa`, `weight`, `amount` — **string**, parse qilib ishlating.

---

## 6. Buyurtmani yangilash

`GET /api/order_update?id=3`

> ⚠️ **Hozir ishlamaydi.** Buyurtma statusi `1` bo'lsa server `500` qaytaradi (backendda xato). Bu endpointni backend tuzatmaguncha ishlatmang.

### Query parametrlar

| Parametr | Tur | Majburiy |
|---|---|---|
| `id` | integer | ha |

### Response

| Holat | Status | Body |
|---|---|---|
| Buyurtma statusi `1` emas | `200` | `false` |
| Buyurtma statusi `1` | `500` | server xatosi |
| Buyurtma topilmadi | `500` | server xatosi |

---

## 7. SMS kod yuborish

`POST /api/before_register`

Telefon raqamga 6 xonali SMS kod yuboradi.

### Request body

| Maydon | Tur | Majburiy | Izoh |
|---|---|---|---|
| `phone` | string | ha | `998XXXXXXXXX` formatida, `+` belgisisiz |
| `name` | string | yangi foydalanuvchi uchun ha | |
| `address` | string | yo'q | |

```json
{
  "phone": "998901234567",
  "name": "Ali",
  "address": "Toshkent, Yunusobod 3/4/31"
}
```

### Response `200 OK`

Muvaffaqiyatli:

```json
{
  "success": true,
  "data": { "timelimit": 180 }
}
```

`timelimit` — sekundlarda, qayta yuborish tugmasi uchun taymer. Server kodning muddatini tekshirmaydi.

Muvaffaqiyatsiz (SMS yuborilmadi yoki foydalanuvchi SMS tasdiqlashni kutmoqda):

```json
false
```

---

## 8. SMS kodni tasdiqlash

`POST /api/after_register`

### Request body

| Maydon | Tur | Majburiy |
|---|---|---|
| `phone` | string | ha |
| `smsCode` | string/number | ha |

```json
{
  "phone": "998901234567",
  "smsCode": "482913"
}
```

### Response `200 OK`

Kod to'g'ri:

```json
true
```

Kod noto'g'ri:

```json
false
```

Javobda token qaytmaydi.

---

## Muhim eslatmalar

1. **SMS oqimi va parol oqimi bir-biriga mos emas.** `before_register` orqali yaratilgan foydalanuvchida parol bo'lmaydi, shuning uchun u `login` qila olmaydi. Shu telefon bilan `register` ham ishlamaydi (`422`, telefon band). Ilovada bittasini tanlang — tavsiya: `register` + `login`.
2. `create_order`, `orders`, `order_update` — **GET** va token talab qilmaydi.
3. Barcha endpointlarda `Accept: application/json` headerini yuboring.
