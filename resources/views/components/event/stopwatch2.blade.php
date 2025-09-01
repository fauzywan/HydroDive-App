
<style>
    /* Tambahkan Google Fonts jika belum ada di proyek Anda */
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');

    .stopwatch-container {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        text-align: center;
        min-width: 350px;
        margin: 20px auto; /* Untuk menempatkan di tengah jika tidak ada flexbox parent */
    }

    .start-time-label { /* Mengganti #start-time */
        font-size: 0.9em;
        color: #777;
        margin-bottom: 15px;
        height: 1.2em; /* Mempertahankan tinggi agar tidak ada CLS saat teks muncul */
    }

    .main-time-display { /* Mengganti #main-time */
        font-family: 'Roboto Mono', monospace;
        font-size: 3.5em;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 25px;
        letter-spacing: 2px;
    }

    .button-group {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 30px;
    }

    .flux-button {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-size: 1.1em;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        font-weight: 600;
    }

    .flux-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .flux-button:active {
        transform: translateY(0);
        box-shadow: none;
    }

    /* Warna spesifik untuk setiap tombol */
    .start-split-button { /* Mengganti .start */
        background-color: #28a745; /* Green */
        color: white;
    }

    .start-split-button:hover {
        background-color: #218838;
    }

    .use-button { /* Mengganti .use */
        background-color: #007bff; /* Blue */
        color: white;
        padding: 8px 15px; /* Lebih kecil untuk tombol di dalam tabel */
        font-size: 0.9em;
    }

    .use-button:hover {
        background-color: #0056b3;
    }

    .reset-button { /* Mengganti .reset */
        background-color: #dc3545; /* Red */
        color: white;
    }

    .reset-button:hover {
        background-color: #c82333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        font-size: 0.95em;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
        color: black; /* Pastikan teks terlihat di latar belakang */
    }

    th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    tbody tr:nth-child(even) {
        background-color: #fefefe;
    }

    tbody tr:hover {
        background-color: #e9ecef;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    #lap-body tr {
        animation: fadeIn 0.4s ease-out;
    }
</style>

<div class="stopwatch-container">
    {{-- Label untuk waktu mulai, akan diisi oleh JS --}}
    <div id="start-time" class="start-time-label"></div>
     <div class="mt-4 text-sm text-black">
        <p><strong>Nama Atlet:</strong> {{ $this->athlete_name }}<br>

        <strong>Nama Event:</strong> {{ $this->selectedEventName }}</p>
     </div>
    {{-- Label utama untuk waktu berjalan --}}
    <div id="main-time" class="main-time-display">00:00.00</div>

    <div class="button-group">
        {{-- Tombol "Use Result" --}}
        <button type="button" class="flux-button use-button" onclick="useResult()">Use Result</button>
        {{-- Tombol "Reset" --}}
        <button type="button" class="flux-button reset-button" onclick="resetTimer()">Reset</button>
        {{-- Tombol "Start / Split" --}}
        <button type="button" class="flux-button start-split-button" onclick="startOrSplit()">Start / Split</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Count</th>
                <th>Lap Time</th>
                <th>Result</th> {{-- Mengganti "Result" menjadi "Action" --}}
            </tr>
        </thead>
        <tbody id="lap-body">
            {{-- Lap times akan di-inject di sini oleh JavaScript --}}
        </tbody>
    </table>
</div>

<script>
    // Variabel global untuk stopwatch
    let startTime = null;     // Waktu saat timer dimulai (absolute time)
    let lastLapTime = 0;      // Waktu terakhir lap dicatat (absolute time)
    let interval = null;      // ID interval untuk setInterval
    let lapCount = 0;         // Menghitung jumlah lap

    // Dapatkan referensi elemen DOM
    const startTimeLabel = document.getElementById('start-time');
    const mainTimeDisplay = document.getElementById('main-time');
    const lapBody = document.getElementById('lap-body');

    /**
     * Fungsi untuk memformat waktu dari milidetik ke MM:SS.CS (Menit:Detik.CentiDetik)
     * @param {number} ms - Waktu dalam milidetik.
     * @returns {string} Waktu yang diformat.
     */
    function formatTime(ms) {
        const totalSeconds = ms / 1000;
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = Math.floor(totalSeconds % 60);
        const milliseconds = Math.floor((ms % 1000) / 10); // Milidetik menjadi centidetik
        return `${pad(minutes)}:${pad(seconds)}.${pad(milliseconds)}`;
    }

    /**
     * Fungsi pembantu untuk menambahkan nol di depan angka tunggal.
     * @param {number} num - Angka yang akan di-pad.
     * @returns {string} Angka dengan nol di depan jika kurang dari 10.
     */
    function pad(num) {
        return num.toString().padStart(2, '0');
    }

    /**
     * Memperbarui tampilan waktu utama.
     */
    function updateTimer() {
        const now = new Date().getTime();
        const diff = now - startTime;
        mainTimeDisplay.textContent = formatTime(diff);
    }

    /**
     * Memulai atau membagi (mencatat lap) stopwatch.
     */
    function startOrSplit() {
        const now = new Date().getTime();

        if (!interval) { // Jika stopwatch belum berjalan, mulai
            startTime = now;
            lastLapTime = now; // Inisialisasi waktu lap terakhir dengan waktu mulai
            startTimeLabel.textContent = `Start Time: ${new Date(startTime).toLocaleTimeString()}`;
            interval = setInterval(updateTimer, 30); // Perbarui setiap 30ms untuk tampilan yang halus
        } else { // Jika stopwatch sudah berjalan, catat lap
            const currentTotalTime = now - startTime; // Total waktu dari awal
            const lapDuration = now - lastLapTime;   // Durasi lap saat ini (selisih dari lastLapTime)

            lapCount++; // Tambah hitungan lap
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${lapCount}</td>
                <td>${formatTime(lapDuration)}</td> {{-- Gunakan lapDuration untuk waktu lap --}}
               <td>${mainTimeDisplay.textContent}</td>
            `;
            lapBody.appendChild(row); // Tambahkan elemen baru di bagian bawah

            lastLapTime = now; // Perbarui waktu lap terakhir untuk lap berikutnya
        }
    }

    /**
     * Mereset stopwatch ke kondisi awal.
     */
    function resetTimer() {
        clearInterval(interval); // Hentikan interval
        interval = null;
        startTime = null;
        lastLapTime = 0;      // Reset waktu lap terakhir
        lapCount = 0;
        mainTimeDisplay.textContent = '00:00.00'; // Reset tampilan waktu
        startTimeLabel.textContent = ''; // Hapus teks waktu mulai
        lapBody.innerHTML = ''; // Hapus semua catatan lap
    }

    /**
     * Menampilkan hasil waktu utama (total waktu).
     * Dapat dimodifikasi untuk berinteraksi dengan backend atau UI lain.
     */
    function useResult() {
        const current = mainTimeDisplay.textContent;
        showCustomAlert(`Using total time: ${current}`);
    }

    /**
     * Menampilkan waktu lap tertentu.
     * Dapat dimodifikasi untuk berinteraksi dengan backend atau UI lain.
     * @param {string} lapTime - Waktu lap individu yang akan digunakan.
     * @param {string} totalTimeAtLap - Total waktu stopwatch saat lap ini dicatat.
     */
    function useLap(lapTime, totalTimeAtLap) {
        showCustomAlert(`Using lap time: ${lapTime} (Total at this lap: ${totalTimeAtLap})`);
    }

    /**
     * Fungsi pengganti alert() untuk lingkungan Livewire/Canvas
     * Menampilkan pesan sederhana di konsol.
     * Di aplikasi nyata, ini bisa menjadi modal kustom.
     */
    function showCustomAlert(message) {
        console.log("Custom Alert:", message);
        // Anda bisa menambahkan logika untuk menampilkan modal UI kustom di sini.
        // Contoh sederhana (tidak direkomendasikan untuk produksi):
        // const alertDiv = document.createElement('div');
        // alertDiv.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0,0,0,0.2); z-index: 1000;';
        // alertDiv.textContent = message;
        // document.body.appendChild(alertDiv);
        // setTimeout(() => alertDiv.remove(), 3000);
    }

    // Menghubungkan fungsi-fungsi JavaScript ke objek `window` agar bisa diakses oleh `onclick`
    window.startOrSplit = startOrSplit;
    window.resetTimer = resetTimer;
    window.useResult = useResult;
    window.useLap = useLap; // Pastikan useLap juga tersedia secara global
</script>
