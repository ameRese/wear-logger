import { getWearDates, updateWearLogs } from './http-request';

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

// 日付をフォーマット
const formatDate = (date) => {
    return date
        .toLocaleDateString('ja-JP', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
        })
        .replaceAll('/', '-');
};

// 日付チェックボックスを作成
const createDateCheckbox = (calDate, inputId) => {
    const formattedCalDate = formatDate(calDate);
    const input = document.createElement('input');
    input.type = 'checkbox';
    input.name = 'date';
    input.value = formattedCalDate;
    input.id = `checkbox${inputId}`;
    input.classList.add('js-date', 'hidden');
    if (selectedWearDates.has(formattedCalDate)) {
        input.checked = true;
    }
    // チェックボックスの変更イベントを設定
    input.addEventListener('change', (e) => {
        if (e.target.checked) {
            selectedWearDates.add(e.target.value);
        } else {
            selectedWearDates.delete(e.target.value);
        }
    });
    return input;
};

// 日付ラベルを作成
const createDateLabel = (calDate, inputId, baseMonth) => {
    const label = document.createElement('label');
    label.setAttribute('for', `checkbox${inputId}`);
    // チェック時のスタイルのみapp.cssで指定
    label.classList.add('cursor-pointer', 'rounded-full', 'flex', 'items-center', 'justify-center');
    // w-8, h-8が機能しなかったので直接設定
    label.style.width = '2rem';
    label.style.height = '2rem';
    label.textContent = calDate.getDate();
    if (calDate.getMonth() !== baseMonth) {
        label.classList.add('text-gray-300');
    }
    return label;
};

// 日付要素を取得
const getDateElement = (calDate, inputId, baseMonth) => {
    const div = document.createElement('div');
    div.classList.add('flex-1', 'p-2', 'flex', 'justify-center');
    const input = createDateCheckbox(calDate, inputId);
    const label = createDateLabel(calDate, inputId, baseMonth);
    div.append(input, label);
    return div;
};

// カレンダーヘッダーを更新
const updateCalendarHeader = (baseDate) => {
    const calendarHeader = document.getElementById('js-calendar-header');
    calendarHeader.textContent = `${baseDate.getFullYear()}年${baseDate.getMonth() + 1}月`;
};

// カレンダーボディを更新
const updateCalendarBody = (calendar) => {
    const calendarBody = document.getElementById('js-calendar-body');
    while (calendarBody.firstChild) {
        calendarBody.removeChild(calendarBody.firstChild);
    }
    calendarBody.append(calendar);
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
        week.classList.add('flex');
        for (let j = 0; j < 7; j++) {
            const date = getDateElement(calDate, idCount, baseDate.getMonth());
            week.append(date);
            calDate.setDate(calDate.getDate() + 1);
            idCount++;
        }
        monthlyCalendar.append(week);
    }
    // カレンダーを更新
    updateCalendarHeader(baseDate);
    updateCalendarBody(monthlyCalendar);
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

document.getElementById('js-update').addEventListener('click', () => {
    const wearDatesToAdd = Array.from(selectedWearDates).filter((v) => !initialWearDates.has(v));
    const wearDatesToDelete = Array.from(initialWearDates).filter((v) => !selectedWearDates.has(v));
    updateWearLogs(wearDatesToAdd, wearDatesToDelete, itemId).then(() => {
        window.location.reload();
    });
});
