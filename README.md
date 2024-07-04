
## About

Source backend, không có frontend.
Setup:

- chạy `composer install`.
- chạy `php artisan migrate`
- chạy `php artisan octane:start` (tham khảo https://laravel.com/docs/11.x/octane)
- mở một tab command line khác, chạy `php artisan app:warm-up` (khởi tạo cache danh sách giải thưởng (reward) và warm-up octane).
- mở một tab khác chạy lệnh `php artisan queue:work`
- nếu dùng nginx thì tạo 1 proxy với domain `flappy_bird.wip` forward qua port 8000 (port của octane start)

## Setup Postman

- tạo biến env `server`, có initial value là http://flappy_bird.wip/api/
- tạo biến env `ACCESS_TOKEN`, có initial value là chuỗi rỗng
- import collection postman bằng file đính kèm trong source
- điền user-agent của postman vào file `resources/user-agents.txt`, đây là nơi lưu trữ danh sách các trình duyệt hợp lệ
- chú ý các header của tất cả request đều phải chứa các dummy header trong file `resources/foobar-headers.txt` (tham khảo các request trong file collection postman đính kèm)
## Danh sách API

- API khởi tạo user (nếu có thì trả về token, nếu không có thì tạo user), sau khi call API, postman tự chạy script ở mục `Scripts`, để lưu giá trị access token vào biến env `ACCESS_TOKEN`
POST init-user
{
    "phone": "0358753662",
    "email": "tranquockiet.cs@gmail.com",
    "name": "quoc kiet"
}
Output:
{
    "message": "ok",
    "is_success": true,
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZmxhcHB5X2JpcmQud2lwL2FwaS9pbml0LXVzZXIiLCJpYXQiOjE3MjAwNzkzODgsImV4cCI6MTcyMDA4Mjk4OCwibmJmIjoxNzIwMDc5Mzg4LCJqdGkiOiIzcmZnSXhnUXZKeUJsRUxSIiwic3ViIjoiMiIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.QuNDFL8mA8V3fAjG1NHF3zb5KOpWc6e0DPcw919_vQk",
        "token_type": "bearer",
        "expires_in": 3600
    }
}

- API init game
POST game
Output:
{
    "message": "ok",
    "is_success": true,
    "data": {
        "id": 5,
        "score": 0,
        "reward_name": "",
        "finished_at": null,
        "is_max_score": false
    }
}

- API gọi khi con chim pass pillar, khi đạt được tối đa 1000 pillar thì chương trình tự động kết thúc (tặng quà và field `is_max_score` = true)
POST game/pass-pillar/{game_id}
OutPut:
{
    "message": "ok",
    "is_success": true,
    "data": {
        "id": 4,
        "score": 1,
        "reward_name": "",
        "finished_at": null,
        "is_max_score": false
    }
}

- API gọi khi con chim hit pillar, 
POST game/hit-pillar/{game_id}
Output:
{
    "message": "ok",
    "is_success": true,
    "data": {
        "id": 4,
        "score": 1,
        "reward_name": "",
        "finished_at": "2024-07-04T08:00:54.000000Z",
        "is_max_score": false
    }

}

- API khởi tạo report, nhận về 1 uuid để check khi nào report được generate xong
POST report
Output:
{
    "message": "ok",
    "is_success": true,
    "data": {
        "uuid": "9a40e98d-df6c-4c54-bd9f-777e37b50d97",
        "path": "",
        "is_error": false
    }
}

- API check report, khi generate report thành công thì sẽ hiện ra đường dẫn để download về 
GET report/{uuid}
Output:
{
    "message": "ok",
    "is_success": true,
    "data": {
        "uuid": "7ada48d4-7b3e-48ea-a58c-9d688b93b747",
        "path": "http://flappy_bird.wip/storage/reports/games/2024/07/04/7ada48d4-7b3e-48ea-a58c-9d688b93b747.xlsx",
        "is_error": false
    }
}

### Security
- Áp dụng RateLimiter của Laravel để hạn chế user-ip request 120/ phút, được cấu hình tại file `app/Providers/AppServiceProvider.php`
- Áp dụng hậu kiểm bằng crontab, ban những user gian lận ở file `routes/console.php`, với logic: ban các user chỉ tạo game mà không chơi, ban các user nhận quà, nhưng chơi ở nhiều ip khác nhau.


