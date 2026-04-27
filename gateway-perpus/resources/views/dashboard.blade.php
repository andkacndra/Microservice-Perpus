<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard Perpustakaan</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
body { font-family: 'Inter', sans-serif; }
</style>
</head>

<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow-xl p-6">
        <h1 class="text-2xl font-bold mb-8">📚 Perpus</h1>

        <nav class="space-y-3">
            <button onclick="showTab('books')" class="menu">📖 Buku</button>
            <button onclick="showTab('users')" class="menu">👤 User</button>
            <button onclick="showTab('loans')" class="menu">🔄 Peminjaman</button>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-8 overflow-y-auto">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold">Dashboard</h2>
            <span class="text-gray-500">Microservice Gateway</span>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="card">
                <p class="text-gray-500">Total Buku</p>
                <h2 id="totalBooks" class="text-2xl font-bold">0</h2>
            </div>
            <div class="card">
                <p class="text-gray-500">Total User</p>
                <h2 id="totalUsers" class="text-2xl font-bold">0</h2>
            </div>
            <div class="card">
                <p class="text-gray-500">Total Peminjaman</p>
                <h2 id="totalLoans" class="text-2xl font-bold">0</h2>
            </div>
        </div>

        <!-- BOOKS -->
        <section id="booksTab">
            <h3 class="title">Kelola Buku</h3>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody id="booksTable"></tbody>
                </table>
            </div>
        </section>

        <!-- USERS -->
        <section id="usersTab" class="hidden">
            <h3 class="title">Kelola User</h3>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody id="usersTable"></tbody>
                </table>
            </div>
        </section>

        <!-- LOANS -->
        <section id="loansTab" class="hidden">
            <h3 class="title">Peminjaman</h3>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="loansTable"></tbody>
                </table>
            </div>
        </section>

    </main>
</div>

<!-- STYLE -->
<style>
.menu {
    display: block;
    width: 100%;
    text-align: left;
    padding: 10px;
    border-radius: 8px;
    transition: 0.2s;
}
.menu:hover {
    background: #f3f4f6;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 15px;
}

.table-wrap {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #f9fafb;
    text-align: left;
    padding: 12px;
    font-weight: 600;
}

.table td {
    padding: 12px;
    border-top: 1px solid #eee;
}
</style>

<!-- SCRIPT -->
<script>

// TAB SWITCH
function showTab(tab) {
    document.getElementById('booksTab').classList.add('hidden');
    document.getElementById('usersTab').classList.add('hidden');
    document.getElementById('loansTab').classList.add('hidden');

    document.getElementById(tab + 'Tab').classList.remove('hidden');
}

// FETCH BOOKS
async function loadBooks() {
    const res = await fetch('/api/books');
    const data = await res.json();

    document.getElementById('totalBooks').innerText = data.length;

    const table = document.getElementById('booksTable');
    table.innerHTML = '';

    data.forEach(b => {
        table.innerHTML += `
        <tr>
            <td>${b.judul ?? '-'}</td>
            <td>${b.penulis ?? '-'}</td>
            <td>${b.stok ?? '-'}</td>
        </tr>`;
    });
}

// FETCH USERS
async function loadUsers() {
    const res = await fetch('/api/users');
    const data = await res.json();

    document.getElementById('totalUsers').innerText = data.length;

    const table = document.getElementById('usersTable');
    table.innerHTML = '';

    data.forEach(u => {
        table.innerHTML += `
        <tr>
            <td>${u.name}</td>
            <td>${u.email}</td>
        </tr>`;
    });
}

// FETCH LOANS
async function loadLoans() {
    const [loanRes, userRes, bookRes] = await Promise.all([
        fetch('/api/loans'),
        fetch('/api/users'),
        fetch('/api/books')
    ]);

    const loans = await loanRes.json();
    const users = await userRes.json();
    const books = await bookRes.json();

    // mapping user
    const userMap = {};
    users.forEach(u => {
        userMap[u.id] = u.name;
    });

    // mapping buku
    const bookMap = {};
    books.forEach(b => {
        bookMap[b.id] = b.judul;
    });

    const table = document.getElementById('loansTable');
    table.innerHTML = '';

    loans.forEach(l => {
        table.innerHTML += `
        <tr>
            <td>${userMap[l.user_id] ?? 'Unknown User'}</td>
            <td>${bookMap[l.book_id] ?? 'Unknown Book'}</td>
            <td>${l.loan_date}</td>
            <td>${l.return_date ?? '-'}</td>
            <td>${l.status}</td>
        </tr>`;
    });

    document.getElementById('totalLoans').innerText = loans.length;
}

// INIT
loadBooks();
loadUsers();
loadLoans();

</script>

</body>
</html>