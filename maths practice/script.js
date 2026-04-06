// Question types and generation
const questionTypes = {
    addition: { symbol: '+', operation: (a, b) => a + b },
    subtraction: { symbol: '-', operation: (a, b) => a - b },
    multiplication: { symbol: '×', operation: (a, b) => a * b },
    division: { symbol: '÷', operation: (a, b) => a / b },
    percentage: { symbol: '%', operation: (a, b) => (a * b) / 100 }
};

// Difficulty settings
const difficultySettings = {
    easy: {
        addition: { min: 1, max: 100 },
        subtraction: { min: 1, max: 100 },
        multiplication: { min: 1, max: 12 },
        division: { divisor: [2, 3, 4, 5, 10], max: 100 },
        percentage: { base: [10, 20, 25, 50, 100], max: 200 }
    },
    medium: {
        addition: { min: 10, max: 1000 },
        subtraction: { min: 10, max: 1000 },
        multiplication: { min: 10, max: 50 },
        division: { divisor: [4, 5, 8, 10, 20, 25], max: 500 },
        percentage: { base: [15, 20, 25, 30, 40, 60], max: 500 }
    },
    hard: {
        addition: { min: 100, max: 10000 },
        subtraction: { min: 100, max: 10000 },
        multiplication: { min: 20, max: 150 },
        division: { divisor: [6, 7, 8, 9, 12, 15, 18], max: 1000 },
        percentage: { base: [12, 17, 23, 33, 37, 48, 67], max: 1000 }
    }
};

// Application state
let state = {
    difficulty: null,
    duration: null,
    startTime: null,
    endTime: null,
    timer: null,
    currentQuestion: null,
    questionNumber: 0,
    answers: [],
    wrongAnswers: []
};

// DOM Elements
const homeScreen = document.getElementById('homeScreen');
const quizScreen = document.getElementById('quizScreen');
const resultsScreen = document.getElementById('resultsScreen');
const difficultyBtns = document.querySelectorAll('.difficulty-btn');
const durationBtns = document.querySelectorAll('.duration-btn');
const startBtn = document.getElementById('startBtn');
const questionText = document.getElementById('questionText');
const answerInput = document.getElementById('answerInput');
const submitBtn = document.getElementById('submitBtn');
const feedback = document.getElementById('feedback');
const timerDisplay = document.getElementById('timer');
const difficultyBadge = document.getElementById('difficultyBadge');
const questionCounter = document.getElementById('questionCounter');
const historyList = document.getElementById('historyList');
const retryBtn = document.getElementById('retryBtn');
const homeBtn = document.getElementById('homeBtn');

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    loadHistory();
    setupEventListeners();
});

function setupEventListeners() {
    // Difficulty selection
    difficultyBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            difficultyBtns.forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            state.difficulty = btn.dataset.difficulty;
            checkStartButton();
        });
    });

    // Duration selection
    durationBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            durationBtns.forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            state.duration = parseInt(btn.dataset.duration);
            checkStartButton();
        });
    });

    // Start button
    startBtn.addEventListener('click', startChallenge);

    // Submit answer
    submitBtn.addEventListener('click', submitAnswer);
    answerInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') submitAnswer();
    });

    // Results buttons
    retryBtn.addEventListener('click', () => {
        showScreen(homeScreen);
        resetState();
    });

    homeBtn.addEventListener('click', () => {
        showScreen(homeScreen);
        resetState();
    });
}

function checkStartButton() {
    startBtn.disabled = !(state.difficulty && state.duration);
}

function startChallenge() {
    state.startTime = Date.now();
    state.endTime = state.startTime + (state.duration * 1000);
    state.questionNumber = 0;
    state.answers = [];
    state.wrongAnswers = [];

    difficultyBadge.textContent = state.difficulty;
    difficultyBadge.className = `difficulty-badge ${state.difficulty}`;

    showScreen(quizScreen);
    startTimer();
    generateQuestion();
}

function startTimer() {
    updateTimer();
    state.timer = setInterval(() => {
        const remaining = state.endTime - Date.now();

        if (remaining <= 0) {
            endChallenge();
        } else {
            updateTimer();
        }
    }, 100);
}

function updateTimer() {
    const remaining = Math.max(0, state.endTime - Date.now());
    const seconds = Math.floor(remaining / 1000);
    const minutes = Math.floor(seconds / 60);
    const secs = seconds % 60;

    timerDisplay.textContent = `${minutes}:${secs.toString().padStart(2, '0')}`;

    if (remaining <= 10000) {
        timerDisplay.classList.add('warning');
    } else {
        timerDisplay.classList.remove('warning');
    }
}

function generateQuestion() {
    const types = Object.keys(questionTypes);
    const randomType = types[Math.floor(Math.random() * types.length)];
    const settings = difficultySettings[state.difficulty][randomType];

    let num1, num2, question, answer;

    switch (randomType) {
        case 'addition':
            num1 = randomInt(settings.min, settings.max);
            num2 = randomInt(settings.min, settings.max);
            question = `${num1} + ${num2}`;
            answer = num1 + num2;
            break;

        case 'subtraction':
            num1 = randomInt(settings.min, settings.max);
            num2 = randomInt(settings.min, num1); // Ensure positive result
            question = `${num1} - ${num2}`;
            answer = num1 - num2;
            break;

        case 'multiplication':
            num1 = randomInt(settings.min, settings.max);
            num2 = randomInt(settings.min, settings.max);
            question = `${num1} × ${num2}`;
            answer = num1 * num2;
            break;

        case 'division':
            const divisor = settings.divisor[Math.floor(Math.random() * settings.divisor.length)];
            const quotient = randomInt(Math.ceil(settings.max / divisor / 2), Math.floor(settings.max / divisor));
            num1 = divisor * quotient; // Ensure clean division
            num2 = divisor;
            question = `${num1} ÷ ${num2}`;
            answer = quotient;
            break;

        case 'percentage':
            const base = settings.base[Math.floor(Math.random() * settings.base.length)];
            num1 = randomInt(settings.max / 2, settings.max);
            question = `${base}% of ${num1}`;
            answer = (base * num1) / 100;
            break;
    }

    state.currentQuestion = {
        question,
        answer: roundToTwo(answer),
        type: randomType
    };

    state.questionNumber++;
    questionCounter.textContent = `Question ${state.questionNumber}`;
    questionText.textContent = question;
    answerInput.value = '';
    answerInput.focus();
    feedback.classList.remove('show');
}

function submitAnswer() {
    const userAnswer = parseFloat(answerInput.value);

    if (isNaN(userAnswer)) {
        showFeedback('Please enter a valid number', false);
        return;
    }

    const isCorrect = Math.abs(userAnswer - state.currentQuestion.answer) < 0.01;

    state.answers.push({
        question: state.currentQuestion.question,
        userAnswer,
        correctAnswer: state.currentQuestion.answer,
        correct: isCorrect
    });

    if (!isCorrect) {
        state.wrongAnswers.push({
            question: state.currentQuestion.question,
            userAnswer,
            correctAnswer: state.currentQuestion.answer
        });
    }

    showFeedback(
        isCorrect ? 'Correct!' : `Incorrect. The answer was ${state.currentQuestion.answer}`,
        isCorrect
    );

    setTimeout(() => {
        generateQuestion();
    }, 800);
}

function showFeedback(message, correct) {
    feedback.textContent = message;
    feedback.className = `feedback show ${correct ? 'correct' : 'incorrect'}`;
}

function endChallenge() {
    clearInterval(state.timer);
    saveHistory();
    showResults();
}

function showResults() {
    const total = state.answers.length;
    const correct = state.answers.filter(a => a.correct).length;
    const accuracy = total > 0 ? Math.round((correct / total) * 100) : 0;

    document.getElementById('totalQuestions').textContent = total;
    document.getElementById('correctAnswers').textContent = correct;
    document.getElementById('accuracyPercent').textContent = `${accuracy}%`;

    const wrongAnswersList = document.getElementById('wrongAnswersList');
    wrongAnswersList.innerHTML = '';

    if (state.wrongAnswers.length > 0) {
        state.wrongAnswers.forEach(wrong => {
            const item = document.createElement('div');
            item.className = 'wrong-answer-item';
            item.innerHTML = `
                <div class="wrong-answer-question">${wrong.question}</div>
                <div class="wrong-answer-details">
                    <span>Your answer: <span class="your-answer">${wrong.userAnswer}</span></span>
                    <span>Correct answer: <span class="correct-answer">${wrong.correctAnswer}</span></span>
                </div>
            `;
            wrongAnswersList.appendChild(item);
        });
    } else {
        wrongAnswersList.innerHTML = '<p style="color: #51cf66; font-weight: 600; text-align: center;">Perfect score! No mistakes!</p>';
    }

    showScreen(resultsScreen);
}

function saveHistory() {
    const total = state.answers.length;
    const correct = state.answers.filter(a => a.correct).length;
    const accuracy = total > 0 ? Math.round((correct / total) * 100) : 0;

    const historyItem = {
        date: new Date().toISOString(),
        difficulty: state.difficulty,
        duration: state.duration,
        totalQuestions: total,
        correctAnswers: correct,
        accuracy
    };

    let history = JSON.parse(localStorage.getItem('mathsDrillHistory') || '[]');
    history.unshift(historyItem);
    history = history.slice(0, 50); // Keep only last 50 entries
    localStorage.setItem('mathsDrillHistory', JSON.stringify(history));
}

function loadHistory() {
    const history = JSON.parse(localStorage.getItem('mathsDrillHistory') || '[]');
    historyList.innerHTML = '';

    if (history.length === 0) {
        historyList.innerHTML = '<p style="color: #999; text-align: center;">No history yet. Start your first challenge!</p>';
        return;
    }

    history.forEach(item => {
        const historyItem = document.createElement('div');
        historyItem.className = 'history-item';

        const date = new Date(item.date);
        const dateStr = date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        historyItem.innerHTML = `
            <div class="history-item-info">
                <span class="history-badge ${item.difficulty}">${item.difficulty}</span>
                <span>${item.duration / 60}min</span>
                <span style="color: #999;">${dateStr}</span>
            </div>
            <div class="history-score">${item.accuracy}% (${item.correctAnswers}/${item.totalQuestions})</div>
        `;
        historyList.appendChild(historyItem);
    });
}

function showScreen(screen) {
    [homeScreen, quizScreen, resultsScreen].forEach(s => s.classList.remove('active'));
    screen.classList.add('active');
}

function resetState() {
    clearInterval(state.timer);
    state.difficulty = null;
    state.duration = null;
    state.currentQuestion = null;
    state.questionNumber = 0;
    state.answers = [];
    state.wrongAnswers = [];

    difficultyBtns.forEach(b => b.classList.remove('selected'));
    durationBtns.forEach(b => b.classList.remove('selected'));
    checkStartButton();
    loadHistory();
}

function randomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function roundToTwo(num) {
    return Math.round(num * 100) / 100;
}
