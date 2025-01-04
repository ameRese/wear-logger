// カレンダー開始日を取得
const getCalStartDate = (baseDate) => {
    let calStartDate = new Date(baseDate.getFullYear(), baseDate.getMonth(), 1);
    const firstDay = calStartDate.getDay();
    calStartDate.setDate(calStartDate.getDate() - firstDay);
    return calStartDate;
};

// カレンダー終了日を取得
const getCalEndDate = (baseDate) => {
    let calEndDate = new Date(baseDate.getFullYear(), baseDate.getMonth() + 1, 0);
    const lastDay = calEndDate.getDay();
    calEndDate.setDate(calEndDate.getDate() + (6 - lastDay));
    return calEndDate;
};

// カレンダー週数を取得
const getCalWeekCount = (calStartDate, calEndDate) => {
    // 1日は86400000ミリ秒
    const msDiff = calEndDate.getTime() - calStartDate.getTime() + 86400000;
    const dateDiff = msDiff / (1000 * 60 * 60 * 24);
    return dateDiff / 7;
};

// 日付要素を取得
const getDateElement = (calDate, inputId) => {
    const div = document.createElement('div');
    div.classList.add('flex-1', 'p-2');

    const input = document.createElement('input');
    input.type = 'checkbox';
    input.name = 'date';
    input.value = calDate;
    input.id = `checkbox${inputId}`;
    input.classList.add('js-date', 'peer', 'hidden');

    const label = document.createElement('label');
    label.setAttribute('for', `checkbox${inputId}`);
    label.classList.add('p-2', 'cursor-pointer', 'peer-checked:bg-blue-500');
    label.textContent = calDate.getDate();

    div.append(input, label);
    return div;
};

// 基準日の月間カレンダー要素を作成
const generateCalendar = (baseDate) => {
    const calStartDate = getCalStartDate(baseDate);
    const calEndDate = getCalEndDate(baseDate);
    const calWeekCount = getCalWeekCount(calStartDate, calEndDate);
    let calDate = calStartDate;
    let idCount = 0;
    const monthlyCalendar = document.createDocumentFragment();
    for (let i = 0; i < calWeekCount; i++) {
        const week = document.createElement('div');
        week.classList.add('flex', 'justify-center', 'text-center');
        for (let j = 0; j < 7; j++) {
            const date = getDateElement(calDate, idCount);
            week.append(date);
            calDate.setDate(calDate.getDate() + 1);
            idCount++
        }
        monthlyCalendar.append(week);
    }

    const calendarHeader = document.getElementById('js-calendar-header');
    calendarHeader.textContent = `${baseDate.getFullYear()}年${baseDate.getMonth() + 1}月`
    // 既存のカレンダー要素を削除してから追加
    const calendarBody = document.getElementById('js-calendar-body');
    while (calendarBody.firstChild) { calendarBody.removeChild(calendarBody.firstChild); }
    calendarBody.append(monthlyCalendar);
};

const today = new Date();
let baseDate = today;
document.addEventListener('DOMContentLoaded', generateCalendar(today));
document.getElementById('js-previous-month').addEventListener('click', () => {
    baseDate.setMonth(baseDate.getMonth() - 1);
    generateCalendar(baseDate);
});
document.getElementById('js-next-month').addEventListener('click', () => {
    baseDate.setMonth(baseDate.getMonth() + 1);
    generateCalendar(baseDate);
});
