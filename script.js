const inputBox = document.getElementById("input-box");
const listContainer = document.getElementById("list-container");
const errorMessage = document.getElementById("error-message");
const authModal = document.querySelector('.auth-modal');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const loginBtnModal = document.querySelector('.login-btn-modal');
const closeBtnModal = document.querySelector('.close-btn-modal');
const profileBox = document.querySelector('.profile-box');
const avatarCircle = document.querySelector('.avatar-circle');
const alertBox = document.querySelector('.alert-box');
const todoLink = document.querySelector('.todo-link');
const contactBox = document.querySelector('.contact');
const conTact = document.querySelector('.con-tact');
const todoApp = document.querySelector('.todo-app');
const home = document.querySelector('.home');
const Weather = document.querySelector('.wea-ther');
const Card = document.querySelector('.card');
const apiKey="06743b608f6296a6069533fc64e60bb0";
const apiUrl="https://api.openweathermap.org/data/2.5/weather?units=metric&q=";
const api_url= "https://api.quotable.io/random";
const quote = document.getElementById("quote");
const author = document.getElementById("author");

const searchBox=document.querySelector(".search input");
const searchBtn=document.querySelector(".search button");
const weatherIcon=document.querySelector(".weather-icon");

Weather.addEventListener('click', () => Card.classList.toggle('show'));

async function checkWeather(city) {
    try {
        const response = await fetch(apiUrl + city + `&appid=${apiKey}`);
        if (!response.ok) throw new Error("API error");
        
        const data = await response.json();
        console.log(data);

        // Hiển thị dữ liệu
        document.querySelector(".city").innerHTML = data.name;
        document.querySelector(".temp").innerHTML = Math.round(data.main.temp) + "°C";
        document.querySelector(".humidity").innerHTML = data.main.humidity + "%";
        document.querySelector(".wind").innerHTML = data.wind.speed + " km/h";

        if(data.weather[0].main == "Clouds"){
        weatherIcon.src = "clouds.png";
        }
        else if(data.weather[0].main == "Clear"){
            weatherIcon.src = "clear.png";
        }
        else if(data.weather[0].main == "Rain"){
            weatherIcon.src = "rain.png";
        }
        else if(data.weather[0].main == "Drizzle"){
            weatherIcon.src = "drizzle.png";
        }
        else if(data.weather[0].main == "Mist"){
            weatherIcon.src = "mist.png";    
        }

    } catch (error) {
        console.error("Lỗi:", error);
        weatherIcon.src = "error.png";
    }
}

// Gọi hàm khi nhấn nút tìm kiếm
searchBtn.addEventListener("click", () => {
    checkWeather(searchBox.value);
});

// Load dữ liệu mặc định khi trang web mở
checkWeather("Hanoi");


let hrs = document.getElementById("hrs");
let min = document.getElementById("min");
let sec = document.getElementById("sec");

setInterval(()=>{
    let currentTime = new Date();
    hrs.innerHTML = (currentTime.getHours()<10?"0":"") + currentTime.getHours();
    min.innerHTML = (currentTime.getMinutes()<10?"0":"") + currentTime.getMinutes();
    sec.innerHTML = (currentTime.getSeconds()<10?"0":"") + currentTime.getSeconds();
},1000)

async function getquote(url){
    const response = await fetch(url);
    var data = await response.json();

    quote.innerHTML = data.content;
    author.innerHTML = data.author;
}
getquote(api_url);

registerLink.addEventListener('click', () => authModal.classList.add('slide'));
loginLink.addEventListener('click', () => authModal.classList.remove('slide'));

if (loginBtnModal) loginBtnModal.addEventListener('click', () => authModal.classList.add('show'));
closeBtnModal.addEventListener('click', () => authModal.classList.remove('show','slide'));

if (avatarCircle) avatarCircle.addEventListener('click', () => profileBox.classList.toggle('show'));

// document.querySelector('.contact').addEventListener('click', function(e) {
//             e.preventDefault();
//             document.querySelector('.con-tact').classList.toggle('show');
//         });
contactBox.addEventListener('click', () => conTact.classList.toggle('show'));

// Clock.addEventListener('click', () => time.classList.toggle('show'));
// document.querySelector('.cloc').addEventListener('click', function(e) {
//             e.preventDefault();
//             document.querySelector('.clock').classList.toggle('show');
//         });
if (avatarCircle) todoLink.addEventListener('click', () => todoApp.classList.toggle('show'));

if (alertBox){
    setTimeout(() => alertBox.classList.add('show'),50);
    
    setTimeout(() => {
        alertBox.classList.remove('show');
        setTimeout(() => alertBox.remove(), 1000);
    },3000);
}

home.addEventListener('click', () => {
    [conTact, profileBox, todoApp, Card].forEach(element => {
        if (element) { // Kiểm tra tồn tại để tránh lỗi 
            element.classList.remove('show');
        }
    });
});


// Kiểm tra các phần tử DOM
// if (!inputBox || !listContainer || !errorMessage) {
//     console.error("Không tìm thấy input-box, list-container hoặc error-message!");
// }

function addTask() {
    const taskText = inputBox.value.trim();
    if (!taskText) {
        showErrorMessage("Nhập nội dung!");
        return;
    }

    const li = document.createElement("li");
    li.textContent = taskText; // Sử dụng textContent thay vì innerHTML để tránh XSS
    
    const span = document.createElement("span");
    span.textContent = "×"; 
    span.className = "delete-btn";
    
    li.appendChild(span);
    listContainer.appendChild(li);
    inputBox.value = '';
    saveData(); // Lưu dữ liệu sau khi thêm
}

function handleTaskClick(e) {
    if (e.target.tagName === "LI") {
        e.target.classList.toggle("checked");
        saveData();
    } else if (e.target.classList.contains("delete-btn")) {
        e.target.parentElement.remove();
        saveData();
    }
}

// Hàm hiển thị thông báo lỗi
function showErrorMessage(message, isSuccess = false) {
    errorMessage.textContent = message;
    errorMessage.style.color = isSuccess ? "green" : "red";
    errorMessage.style.display = "block";
    
    setTimeout(() => {
        errorMessage.style.display = "none";
    }, 3000);
}

// Hàm lưu dữ liệu vào localStorage
function saveData() {
    localStorage.setItem("todoData", listContainer.innerHTML);
}

// Hàm load dữ liệu từ localStorage
function loadData() {
    const savedData = localStorage.getItem("todoData");
    if (savedData) {
        listContainer.innerHTML = savedData;
    }
}
// Thêm các hàm hiển thị thông báo
function showLoadingMessage(message) {
    errorMessage.textContent = message;
    errorMessage.style.color = "blue";
    errorMessage.style.display = "block";
}

function showSuccessMessage(message) {
    errorMessage.textContent = message;
    errorMessage.style.color = "green";
    errorMessage.style.display = "block";
    setTimeout(() => {
        errorMessage.style.display = "none";
    }, 3000);
}

// Sửa hàm exportToCSV
function exportToCSV() {
    // Kiểm tra đăng nhập
    const isLoggedIn = document.querySelector('.profile-box') !== null;
    if (!isLoggedIn) {
        showErrorMessage("Vui lòng đăng nhập để sử dụng tính năng này!");
        authModal.classList.add('show'); // Mở modal đăng nhập
        return;
    }

    const tasks = Array.from(listContainer.children).map((li, index) => {
        const text = li.textContent.replace('×', '').trim();
        return {
            stt: index + 1,
            task: text,
            status: li.classList.contains("checked") ? "Finished" : "Unfinished"
        };
    });

    if (tasks.length === 0) {
        showErrorMessage("Không có công việc nào để xuất!");
        return;
    }

    // Tạo nội dung CSV
    const header = "STT,Task,Status";
    const rows = tasks.map(item => `"${item.stt}","${item.task.replace(/"/g, '""')}","${item.status}"`);
    const csvContent = `sep=,\r\n${[header, ...rows].join('\r\n')}`;
    const filename = `Todo-List-${new Date().toISOString().slice(0, 10)}.csv`;

    // 1. Tải file về máy
    const blob = new Blob(["\uFEFF" + csvContent], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();

    // 2. Gửi email (chỉ khi đã đăng nhập)
    showLoadingMessage("Đang gửi email...");
    fetch('send_email.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ csvContent, filename })
    })
    .then(response => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showSuccessMessage("Đã gửi file CSV về email của bạn!");
        } else {
            showErrorMessage(`Gửi email thất bại: ${data.message}`);
        }
    })
    .catch(error => {
        showErrorMessage("Lỗi kết nối đến server");
        console.error("Error:", error);
    });
}

// Enter
listContainer.addEventListener("click", handleTaskClick);
inputBox.addEventListener("keypress", (e) => {
    if (e.key === "Enter") addTask();
});

// Tải dữ liệu khi trang web được load
document.addEventListener("DOMContentLoaded", loadData);