import { getWearDates, updateWearLogs } from './HttpRequest';

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
    const dateDiff = msDiff / 86400000;
    return dateDiff / 7;
};

// 日付要素を取得
const getDateElement = (calDate, inputId, baseMonth) => {
    const div = document.createElement('div');
    div.classList.add('flex-1', 'p-2');

    const formattedCalDate = calDate.toLocaleDateString('ja-JP', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
    }).replaceAll('/', '-');
    const input = document.createElement('input');
    input.type = 'checkbox';
    input.name = 'date';
    input.value = formattedCalDate;
    input.id = `checkbox${inputId}`;
    input.classList.add('js-date', 'peer', 'hidden');
    if (selectedWearDates.has(formattedCalDate)) { input.checked = true; }

    const label = document.createElement('label');
    label.setAttribute('for', `checkbox${inputId}`);
    label.classList.add('p-2', 'cursor-pointer', 'peer-checked:bg-blue-500');
    label.textContent = calDate.getDate();
    if (calDate.getMonth() !== baseMonth) { label.classList.add('text-gray-300'); }

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
            const date = getDateElement(calDate, idCount, baseDate.getMonth());
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

    const calendarDates = document.querySelectorAll('.js-date');
    for (let calendarDate of calendarDates) {
        calendarDate.addEventListener('change', e => {
            if (e.target.checked) {
                selectedWearDates.add(e.target.value);
            } else {
                selectedWearDates.delete(e.target.value);
            }
        });
    }
};

const today = new Date();
let baseDate = new Date(today.getFullYear(), today.getMonth(), 1);
let initialWearDates = new Set();
let selectedWearDates = new Set();
const itemId = document.getElementById('js-item-id').textContent;
document.addEventListener('DOMContentLoaded', async () => {
    const wearDates = await getWearDates(itemId);
    initialWearDates = new Set(wearDates);
    selectedWearDates = new Set(initialWearDates);
    generateCalendar(today);
});

document.getElementById('js-previous-month').addEventListener('click', () => {
    baseDate.setMonth(baseDate.getMonth() - 1);
    generateCalendar(baseDate);
});

document.getElementById('js-next-month').addEventListener('click', () => {
    baseDate.setMonth(baseDate.getMonth() + 1);
    generateCalendar(baseDate);
});

document.getElementById('js-update').addEventListener('click', (e) => {
    const wearDatesToAdd = Array.from(selectedWearDates).filter(v => !initialWearDates.has(v));
    const wearDatesToDelete = Array.from(initialWearDates).filter(v => !selectedWearDates.has(v));
    updateWearLogs(wearDatesToAdd, wearDatesToDelete, itemId)
        .then(() => {
            window.location.reload();
        });
});
