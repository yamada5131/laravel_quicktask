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

