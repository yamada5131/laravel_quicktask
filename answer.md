### Chapter2:

1. Migration là gì?

   > Migration có thể hiểu như là một version control của DB, cho phép các thành viên trong team định nghĩa và chia sẻ
   các database schema(table, column).

2. Hàm `up()` và hàm `down()` trong class migration dùng để làm gì?

    - Hàm up dùng để khởi tạo bảng, cột hoặc index cho database
    - Hàm down thực hiện các thao tác ngược lại so với hàm up

3. Nêu các câu lệnh migration thông dụng mà bạn biết

    - `migration` - thực thi các migration mới
    - `migration:rollback` - rollback lại các migration đã thực hiện trước đó
    - `migration:reset` - rollback lại tất cả các migration
    - `migration:fresh` - Drop tất cả các table vào chạy migrate lại
    - `migration:status` - Hiện thị status của từng migration
    - `migration:refresh` - Reset và chạy lại tất cả các migration

---

1. Mass assignment là gì?
   > Mass assignment là một lỗ hổng xảy ra khi người dùng gửi unexpected HTTP Request field và filed đấy sẽ thay đổi dữ
   liệu trong database mà bạn không ngờ tới.
2. Cách xử lý mass assignment trong laravel:
    - `$fillable` và `$guarded` attributes
3. Tại sao laravel có cả thuộc tính fillable và guarded?
    - Vì Eloquent model mặc định bảo vệ DB khỏi mass assignment.
4. Cập nhật các thuộc tính trong blacklist
    - Cập Nhật Thuộc Tính Bằng Cách Truy Cập Trực Tiếp hoặc thay đổi guarded tạm thời.

---

### Chapter3:

1. Kể tên các quan hệ trong laravel và phương thức tương ứng

    - One to one:
      In the User model:
      ``` php
       return $this->hasOne(Phone::class);
       ```
    - One To Many:
        - In the Post model:
        ``` php
        return $this->hasMany(Comment::class);
        ```
        - In the Comment model:
        ``` php
        return $this->belongsTo(Post::class);
        ```
    - Many To Many:
        - users
          id - integer
          name - string

        - roles
          id - integer
          name - string

        - role_user -> pivot table
          user_id - integer
          role_id - integer

        - In the User model:
        ``` php
        return $this->belongsToMany(Role::class);
        ```

        - In the Role model:
        ``` php
        return $this->belongsToMany(User::class)
        ```
2. Các hàm `attach()`, `detach()`, `toggle()`, `sync()` dùng để làm gì
    - Các hàm trên được sử dụng để làm việc với quan hệ n-n
    - `attach()` như ví dụ dưới đây dùng để gán role cho một user bằng cách thêm một bản ghi vào bản quan hệ trung gian
    ``` php
    use App\Models\User;

    $user = User::find(1);

    $user->roles()->attach($roleId);
    ```
    - `detach()` dùng để xóa role ra khỏi user
   ``` php
   // Detach a single role from the user...
    $user->roles()->detach($roleId);

    // Detach all roles from the user...
    $user->roles()->detach();
   ```
    - `sync()` dùng để cấu tạo ra các liên kết n-n
    - `toogle()`
3. Làm thế nào để lấy dữ liệu từ bảng trung gian trong quan hệ n-n
    - Sử dụng **pivot attribute**:
    ```php
    use App\Models\User;

    $user = User::find(1);

    foreach ($user->roles as $role) {
        echo $role->pivot->created_at;
    }
    ```

---

### Chapter4

#### **Accessors/Mutators** dùng để làm gì?

- Dùng để **biến đổi dữ liệu** khi truy vấn hoặc thêm vào các mô hình thực thể (model instance). Ví dụ khi muốn mã hóa
  một dữ liệu khi lưu trữ vào trong database và tự động giải mã khi lấy nó ra.

#### Tạo Accessors and Mutators thế nào? [Laravel Docs](https://laravel.com/docs/11.x/eloquent-mutators#accessors-and-mutators)

- **Định nghĩa một Accessor**
    1. Tạo ra một protected method trong model
    2. Đặt tên method theo kiểu "camelCase" tương ứng với cột của DB muốn áp dụng
    3. Luôn định nghĩa kiểu trả về là `Illuminate\Database\Eloquent\Casts\Attribute`
    4. Để định nghĩa cách mà atribute sẽ được accessed thì cung cấp một biến `get` cho constructor của
       của `Attribute class`.

   ``` php
   <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Casts\Attribute;
    use Illuminate\Database\Eloquent\Model;

    class User extends Model
    {
    /**
    * Get the user's first_name.
    */
        protected function firstName(): Attribute
        {
            return Attribute::make(
                get: fn (string $value) => ucfirst($value),
            );
        }
    }
   ```

    - Để truy cập vào giá trị của accessor, đơn truy cập thuộc tính `first_name` trong mô hình thực thể

       ``` php
       use App\Models\User;

       $user = User::find(1);

       $firstName = $user->first_name;
       ```
- **Định nghĩa mutator:** mutator sẽ **tự động** biến đổi giá trị thuộc tính của Eloquent khi nó được set. Để định nghĩa
  mutator thì thêm tham số `set`

``` php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Interact with the user's first name.
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value),
        );
    }
}
```

- Để sử dụng mutator chỉ cần set giá trị thuộc tính của Eloquent model:

``` php
use App\Models\User;

$user = User::find(1);

$user->first_name = 'Sally';
```

#### [Scope](https://laravel.com/docs/11.x/eloquent#query-scopes)

##### Scope dùng để làm gì?

- **Global scope:** Dùng để thêm ràng buộc cho tất cả các câu truy vấn trên một thực thể
    - Khởi tạo: `php artisan make:scope AncientScope`
        - Viết một cái global scope:
            - khởi tạo -> `app/Models/Scopes` -> implement apply method(có thể có dàng buộc `where` hoặc là các câu
              query
              khác nếu cần)
            ``` php
            <?php

            namespace App\Models\Scopes;

            use Illuminate\Database\Eloquent\Builder;
            use Illuminate\Database\Eloquent\Model;
            use Illuminate\Database\Eloquent\Scope;

            class AncientScope implements Scope
            {
            /**

            * Apply the scope to a given Eloquent query builder.
              */
              public function apply(Builder $builder, Model $model): void
              {
                  $builder->where('created_at', '<', now()->subYears(2000));
              }
            }

            ```
- Local scope: dùng để định nghĩa những ràng buộc truy vấn thường được sử dụng -> tái sử dụng
    - Để định nghĩa local scope, thêm prefix `scope` vào trước eloquent method -> trả về query builder hoặc void
    ``` php
    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;

    class User extends Model
    {
        /**
        * Scope a query to only include popular users.
        */
        public function scopePopular(Builder $query): void
        {
            $query->where('votes', '>', 100);
        }

        /**
         * Scope a query to only include active users.
         */
        public function scopeActive(Builder $query): void
        {
            $query->where('active', 1);
        }
    }

    ```
---

### Chapter5

1. Seeder/Factory/Faker dùng để làm gì?
- Seeder: Dùng để tạo dữ liệu mẫu thủ công vào database

    `php artisan make:seeder UserSeeder`

- Factory: Dùng để thêm lượng lớn dữ liệu mẫu vào database
- Faker: là một thư viện PHP dùng để tạo dữ liệu giả lập, phục vụ cho việc testing và seeding
1. Khi nào nên sử dụng Seeder? Khi nào sử dụng Factory?
- Seeder: Khi bạn cần chèn dữ liệu cụ thể, cố định vào cơ sở dữ liệu cho các mục đích như khởi tạo, cấu hình, hoặc chuẩn bị dữ liệu cho ứng dụng
- Factory: Khi bạn cần tạo dữ liệu mẫu hoặc ngẫu nhiên cho các mục đích phát triển hoặc kiểm thử. Factory giúp tạo ra nhiều bản ghi nhanh chóng và hiệu quả hơn.

---

### Chapter6
1. Mô tả cấu trúc của một route trong laravel
- Cấu trúc cơ bản của một route trong laravel bao gồm URL và closure
``` php
use Illuminate\Support\Facades\Route;

Route::get('/greeting', function () {
    return 'Hello World';
});
```
2. Kể tên các hàm trong Resource Controller và phương thức/công dụng tương ứng
- `index()`: Hiển thị danh sách tất cả các bản ghi
- `create()`: Hiển thị form tạo mới
- `store()`: Lưu bản ghi mới
- `show()`: Hiển thị một bản ghi cụ thể
- `edit()`: Hiển thị form chỉnh sửa
- `update()`: Cập nhật bản ghi
- `destroy()`: Xóa bản ghi

---

### Chapter7
1. Middleware dùng để làm gì?
    > Middleware cung cấp một cơ chế tiện lợi để kiểm tra và lọc các HTTP request đến ứng dụng của bạn. Lấy ví dụ, Laravel bao gồm một middleware để xác thực người dùng. Nếu người dùng không được xác thực, middleware sẽ chuyển hướng người dùng đến trang đăng nhập. Tuy nhiên, nếu người dùng đã được xác thực, middleware sẽ cho phép request tiếp tục vào ứng dụng.
2. Phân biết global middleware, group middleware và route middleware
- Global middleware: Middleware được thực thi trước tất cả các request vào ứng dụng
- Route middleware: Middleware được chỉ định cho một route cụ thể
- Group middleware: nhóm nhiều middleware lại với nhau và chỉ định cho một nhóm route cụ thể

---

### Chapter8
1. Bạn biết những starter kit authentication nào trong laravel?
- Laravel Breeze, Laravel Jetstream, Laravel Fortify, Laravel UI, Laravel Sanctum, Laravel Passport,...
2. Trong quicktask bạn dùng starter kit nào? Khi cần custom logic bạn sẽ làm như thế nào?
- edit `app/Http/Controllers/Auth/*` để custom logic
