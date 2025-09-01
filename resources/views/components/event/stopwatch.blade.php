<div>
     <style>
.finish-button {
    background-color: #28a745; /* Hijau */
    color: white;
}

.finish-button:hover {
    background-color: #218838;
}
        .stopwatch-container {
            background-color: #2c2c3e; /* Dark background similar to image */
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 30px;
            text-align: center;
            width: 90%;
            max-width: 380px; /* Default max-width for mobile */
            color: #fff;
            position: relative; /* Needed for absolute positioning of custom alert */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            color: #ccc;
            font-size: 0.9em;
        }

        .header .time {
            font-weight: bold;
        }

        .header .title {
            font-size: 1.2em;
            font-weight: 600;
        }

        .main-time-display {
            font-family: 'Roboto Mono', monospace;
            font-size: 3.5em; /* Default font size for mobile */
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 30px;
            letter-spacing: 2px;
        }

        .power-button-wrapper {
            position: relative;
            width: 180px; /* Default button size */
            height: 180px; /* Default button size */
            margin: 0 auto 40px; /* Centered */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .power-button-circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #4a4a5c; /* Darker background for the button */
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 1; /* Ensure it's above the progress ring */
        }

        .power-button-circle:hover {
            background-color: #5a5a6c;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .power-button-circle:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .power-button-icon {
            font-size: 3.5em; /* Default icon size */
            color: #ffffff; /* White icon */
        }

        /* Progress ring - adapted from a common SVG trick */
        .progress-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            transform: rotate(-90deg); /* Start from the top */
            z-index: 0;
        }

        .progress-ring-circle {
            stroke-dasharray: 534px; /* Default for 85px radius */
            stroke-dashoffset: 534px; /* Full circle */
            transition: stroke-dashoffset 0.1s linear; /* Smooth animation for progress */
            stroke: #8a48d8; /* Purple color */
            stroke-width: 10;
            fill: transparent;
        }

        .lap-time-card-group {
            display: flex;
            flex-direction: column; /* Stack vertically for mobile */
            gap: 15px;
            margin-bottom: 30px;
        }

        .lap-time-card {
            background-color: #4a4a5c; /* Darker background for cards */
            border-radius: 8px;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.95em;
            color: #eee;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease;
        }

        .lap-time-card:hover {
            transform: translateY(-2px);
        }

        .lap-time-card .icon {
            color: #8a48d8; /* Purple icon */
            margin-right: 10px;
            font-size: 1.1em;
        }

        .lap-time-card .lap-duration {
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        .lap-time-card .total-at-lap {
            font-family: 'Roboto Mono', monospace; /* Use monospaced for times */
            color: #cccccc;
        }

        .button-group {
            display: flex;
            justify-content: space-around; /* Distribute evenly */
            gap: 15px; /* Space between buttons */
            margin-top: 30px;
        }

        .flux-button {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            font-weight: 600;
            flex-grow: 1; /* Allow buttons to grow and fill space */
        }

        .flux-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .flux-button:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .lap-button {
            background-color: #8a48d8; /* Purple similar to image */
            color: white;
        }

        .lap-button:hover {
            background-color: #7a3aa3;
        }

        .reset-button {
            background-color: #dc3545; /* Red */
            color: white;
        }

        .reset-button:hover {
            background-color: #c82333;
        }

        /* Custom Alert styling */
        .custom-alert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #4a4a5c;
            color: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            max-width: 80%;
            text-align: center;
        }

        .custom-alert.show {
            opacity: 1;
            visibility: visible;
        }

        .custom-alert button {
            background-color: #8a48d8;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .custom-alert button:hover {
            background-color: #7a3aa3;
        }

        /* Media queries for desktop (md breakpoint and up) */
        @media (min-width: 768px) { /* md breakpoint */
            .stopwatch-container {
                max-width: 450px; /* Increased max-width for desktop */
                padding: 40px; /* More padding */
            }

            .main-time-display {
                font-size: 3em; /* Larger font for main time */
            }

            .power-button-wrapper {
                width: 220px; /* Larger button for desktop */
                height: 220px; /* Larger button for desktop */
                margin-bottom: 50px;
            }

            .power-button-icon {
                font-size: 4.5em; /* Larger icon */
            }

            .progress-ring-circle {
                stroke-dasharray: 659.73px; /* 2 * PI * R, where R = 105 */
                stroke-dashoffset: 659.73px;
            }

            .lap-time-card-group {
                gap: 20px; /* More space between lap cards */
            }

            .lap-time-card {
                padding: 18px 25px; /* Slightly more padding for cards */
                font-size: 1em;
            }

            .flux-button {
                padding: 15px 30px; /* Larger buttons */
                font-size: 1.2em;
            }
        }
    </style>

    <div class="stopwatch-container">
        <!-- Header Section -->
        <div class="header">
            <div class="title">{{ $this->selectedEventName }} <br class="mt-2">{{$this->athlete_name}}</div>
            <div class="menu-icon">
                <i class="fas fa-ellipsis-v"></i>
            </div>
        </div>

        <!-- Main Time Display -->
        <div id="main-time" class="main-time-display">00:00:00</div>

        <!-- Power/Start Button with Progress Ring -->
        <div class="power-button-wrapper">
            <svg class="progress-ring" width="220" height="220" viewBox="0 0 220 220">
                <!-- r=105, cx=110, cy=110 -->
                <circle class="progress-ring-circle" stroke-width="10" stroke="#8a48d8" fill="transparent"
                        r="105" cx="110" cy="110"></circle>
            </svg>
            <div id="power-button" class="power-button-circle">
                <i class="fas fa-power-off power-button-icon"></i>
            </div>
        </div>

        <!-- Lap Time Cards Container -->
        <div id="lap-time-card-group" class="lap-time-card-group">
            <!-- Lap time cards will be inserted here by JavaScript -->
        </div>

        <!-- Action Buttons -->
       <div class="button-group">

    <button type="button" class="flux-button reset-button" onclick="resetTimer()">
        <i class="fas fa-times-circle mr-2"></i>Reset
    </button>
</div>
<button id="finish-button" type="button" class="flux-button finish-button w-full mt-5" onclick="finishTimer()" style="display: none;">
    <i class="fas fa-check-circle mr-2"></i>Finish
</button>
    </div>

    <!-- Custom Alert Container -->
    <div id="custom-alert" class="custom-alert">
        <p id="alert-message"></p>
        <button onclick="hideCustomAlert()">OK</button>
    </div>
<script>
    // Global variables for the stopwatch
    let startTime = null;
    let lastLapTime = 0;
    let interval = null;
    let lapCount = 0;
    let isRunning = false;

    // DOM element references
    const mainTimeDisplay = document.getElementById('main-time');
    const powerButtonWrapper = document.querySelector('.power-button-wrapper');
    const powerButton = document.getElementById('power-button');
    const lapTimeCardGroup = document.getElementById('lap-time-card-group');
    const progressCircle = document.querySelector('.progress-ring-circle');
    const finishButton = document.getElementById('finish-button');

    // Dynamically get the radius from the SVG circle for circumference calculation
    const radius = progressCircle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;

    // Initialize progress ring
    progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
    progressCircle.style.strokeDashoffset = circumference;

    // Initial state: finish button hidden, power button visible
    finishButton.style.display = 'none';
    powerButtonWrapper.style.display = 'flex';

    /**
     * Formats time from milliseconds to MM:SS:CS (Minutes:Seconds:CentiSeconds)
     * @param {number} ms - Time in milliseconds.
     * @returns {string} Formatted time string.
     */
    function formatTime(ms) {
        const totalSeconds = ms / 1000;
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = Math.floor(totalSeconds % 60);
        const milliseconds = Math.floor((ms % 1000) / 10);
        return `${pad(minutes)}:${pad(seconds)}:${pad(milliseconds)}`;
    }

    /**
     * Helper function to add leading zero to single digit numbers.
     * @param {number} num - Number to pad.
     * @returns {string} Padded number string.
     */
    function pad(num) {
        return num.toString().padStart(2, '0');
    }

    /**
     * Updates the main time display and progress ring.
     */
    function updateTimer() {
        const now = new Date().getTime();
        const diff = now - startTime;
        mainTimeDisplay.textContent = formatTime(diff);

        const progress = (diff % 60000) / 60000;
        const offset = circumference - progress * circumference;
        progressCircle.style.strokeDashoffset = offset;
    }

    /**
     * Starts the stopwatch session.
     * This button only starts the timer and then becomes inactive/hidden.
     */
    function startTimerSession() {
        if (!isRunning) {
            startTime = new Date().getTime();
            lastLapTime = new Date().getTime();
            interval = setInterval(updateTimer, 30);
            isRunning = true;
            // Hide the power button wrapper
            powerButtonWrapper.style.display = 'none';
            // Show the finish button
            finishButton.style.display = 'block';
        } else {
        }
    }

    /**
     * Records a lap time.
     */
    function recordLap() {
        if (isRunning) {
            const now = new Date().getTime();
            const lapDuration = now - lastLapTime;
            const currentTotalTime = now - startTime;

            lapCount++;
            const lapCard = document.createElement('div');
            lapCard.classList.add('lap-time-card', 'rounded-lg', 'shadow-md', 'p-4', 'flex', 'items-center', 'justify-between');
            lapCard.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-redo-alt icon mr-2"></i>
                    <span class="lap-duration text-lg">${formatTime(lapDuration)}</span>
                </div>
                <span class="total-at-lap text-sm">${formatTime(currentTotalTime)}</span>
            `;
            lapTimeCardGroup.prepend(lapCard);
            lastLapTime = now;
        } else {
            showCustomAlert("Stopwatch tidak berjalan. Tekan tombol tengah untuk memulai.");
        }
    }

    /**
     * Resets the stopwatch to its initial state, clearing everything.
     */
    function resetTimer() {
        clearInterval(interval);
        interval = null;
        startTime = null;
        lastLapTime = 0;
        lapCount = 0;
        isRunning = false;
        mainTimeDisplay.textContent = '00:00:00';
        lapTimeCardGroup.innerHTML = ''; // <-- Ini yang menghapus lap records
        progressCircle.style.strokeDashoffset = circumference;

        // Reset button visibility
        powerButtonWrapper.style.display = 'flex';
        finishButton.style.display = 'none';

        showCustomAlert("Stopwatch telah direset.");
    }

    /**
     * Stops the stopwatch, records final time, keeps laps, and triggers Livewire event.
     */
function finishTimer() {
    if (isRunning) {
        clearInterval(interval);
        interval = null;
        isRunning = false;
        const finalTimeMs = new Date().getTime() - startTime;

        // Collect all lap times
        const lapCards = lapTimeCardGroup.querySelectorAll('.lap-time-card');
        const lapTimes = [];
        lapCards.forEach(card => {
            const lapDurationText = card.querySelector('.lap-duration').textContent;
            const totalAtLapText = card.querySelector('.total-at-lap').textContent;
            // You might need a helper function to convert HH:MM:SS:CS back to milliseconds
            // For simplicity, let's assume we're sending the formatted strings.
            // If you need milliseconds, you'll have to parse them.
            lapTimes.push({
                lapDuration: lapDurationText,
                totalAtLap: totalAtLapText
            });
        });

        // Trigger the Livewire event with the final time and lap times
        @this.call('FinishStopWatch', finalTimeMs, lapTimes); // Pass lapTimes array

        showCustomAlert(`Sesi selesai! Total waktu: ${formatTime(finalTimeMs)}`);

        startTime = null;
        lastLapTime = 0;
        lapCount = 0;
        progressCircle.style.strokeDashoffset = circumference;

        powerButtonWrapper.style.display = 'flex';
        finishButton.style.display = 'none';

    } else {
        showCustomAlert("Tidak ada sesi yang berjalan untuk diselesaikan.");
    }
}

// You might need a function to convert formatted time string back to milliseconds
// For example:
function timeToMs(timeString) {
    const parts = timeString.split(':');
    const minutes = parseInt(parts[0]);
    const seconds = parseInt(parts[1]);
    const centiSeconds = parseInt(parts[2]);
    return (minutes * 60 * 1000) + (seconds * 1000) + (centiSeconds * 10);
}
    /**
     * Displays a custom alert message.
     * @param {string} message - The message to display.
     */
    function showCustomAlert(message) {
        const alertDiv = document.getElementById('custom-alert');
        const alertMessage = document.getElementById('alert-message');
        alertMessage.textContent = message;
        alertDiv.classList.add('show');
    }

    /**
     * Hides the custom alert message.
     */
    function hideCustomAlert() {
        const alertDiv = document.getElementById('custom-alert');
        alertDiv.classList.remove('show');
    }

    // Event listener for the power button, now only starts the session
    powerButton.addEventListener('click', startTimerSession);

    // Making functions globally accessible for onclick attributes
    window.recordLap = recordLap;
    window.resetTimer = resetTimer;
    window.finishTimer = finishTimer;
    window.showCustomAlert = showCustomAlert;
    window.hideCustomAlert = hideCustomAlert;
</script>
</div>
