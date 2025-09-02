<?php

session_start();

$name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['alerts'] ?? [];
$active_form = $_SESSION['active_form'] ?? '';

session_unset();

if ($name !== null) $_SESSION['name'] = $name;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        <a href="#" class="logo">Nơi giúp bạn đỡ lười</a>
        <nav>
            <a href="#" class="home">Trang chủ</a>
            <a href="#" class="todo-link">Việc cần làm</a>
            <a href="#" class="wea-ther">Thời tiết</a>
            <a href="#" class="contact">Liên hệ</a>
                <div class="con-tact">
                    <p>0967236791</p>
                    <p>khieuhuutiendung@gmail.com</p>
                </div>  
        </nav>
        <div class="user-auth">
            <?php if (!empty($name)): ?>
            <div class="profile-box">
                <div class="avatar-circle"><?php echo strtoupper($name[0]); ?></div>
                <div class="dropdown">
                    <a href="logout.php">Logout</a>
                </div>
            </div>
            <?php else: ?>
            <button type="button" class="login-btn-modal" >Login</button>
            <?php endif; ?>
        </div>
    </header>
    <div class="container">
        <div class="todo-app">
            <h1>To-do list <img src="icon.png" alt="To-do icon"></h1>
            <div class="row">
                <input type="text" id="input-box" placeholder="Add your text">
                <button onclick="addTask()" id="btn-1">Add</button>
                <button onclick="exportToCSV()"id="btn-1">Export</button>
            </div>
            <div id="error-message" style="color: red; display: none;"></div>
            <ul id="list-container"></ul>
        </div>
        <h2 class="hi">Hi <?php echo $name?? 'thằng lười, đăng ký đi cu' ?>!!!</h2>

    <div class="quote-box">
        <h2>Quote of the day</h2>
        <blockquote id="quote">Loading...</blockquote>
        <span id="author">Loading...</span>
        <div>
            <button onclick="getquote(api_url)">New quote</button>
        </div>
    </div>    
        
    <div class="card">
        <div class="search">
            <input type="text" placeholder="enter city" spellcheck="false">
            <button><img src="search.png"></button>
        </div>
        <div class="weather">
            <img src="clear.png" class="weather-icon">
            <h1 class="temp">22°C</h1>
            <h2 class="city">Hanoi</h2>
            <div class="details">
                <div class="col">
                    <img src="humidity.png">
                    <div>
                        <p class="humidity">50%</p>
                        <p>Humidity</p>
                    </div>
                </div>
                <div class="col">
                    <img src="wind.png">
                    <div>
                        <p class="wind">15 km/h</p>
                        <p>Wind Speed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>       
    </div>
    <div class="time">
            <div class="clock">
            <span id="hrs">00</span>
            <span>:</span>
            <span id="min">00</span>
            <span>:</span>
            <span id="sec">00</span>
            </div>    
        </div>
     
    <?php if (!empty($alerts)): ?>
    <div class="alert-box">
        <?php foreach ($alerts as $alert): ?>
        <div class="alert <?php echo $alert['type']; ?>">
            <i class='bx <?php echo $alert['type'] === 'success' ?  'bxs-checkbox-checked' : 'bxs-x-circle';?>'></i>
            <span><?php echo $alert['message']; ?></span> 
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="auth-modal <?php echo $active_form === 'register' ? 'show-slide' : ($active_form === 'login' ? 'show' : ''); ?>">
        <button type="button" class="close-btn-modal"><i class='bx bxs-x'></i> </button>
        <div class="form-box login">
            <h2>Login</h2>
            <form action="auth_process.php" method="POST">
                <div class="input-box1">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i> 
                </div>
                <div class="input-box1">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock'></i> 
                </div>
                <button type="submit" name="login_btn" class="btn">Login</button>
                <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
            </form>
        </div>

        <div class="form-box register">
            <h2>Register</h2>
            <form action="auth_process.php" method="POST">
                <div class="input-box1">
                    <input type="text" name="name" placeholder="Name" required>
                    <i class='bx bxs-user'  ></i>  
                </div>
                <div class="input-box1">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i> 
                </div>
                <div class="input-box1">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock'></i> 
                </div>
                <button type="submit" name="register_btn" class="btn">Register</button>
                <p>Already have an account? <a href="#" class="login-link">Login</a></p>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>