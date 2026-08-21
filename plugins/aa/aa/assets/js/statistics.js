// تهيئة الرسوم البيانية باستخدام Chart.js
function createPieChart(canvasId, labels, data, colors) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;
    
    // التحقق من وجود بيانات
    if (!data || data.length === 0 || data.every(v => v === 0)) {
        ctx.parentElement.innerHTML = '<div class="no-data">لا توجد بيانات للعرض</div>';
        return;
    }
    
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
                borderWidth: 3,
                borderColor: '#fff',
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 12,
                            family: 'Tahoma'
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
}

function createBarChart(canvasId, labels, data, color) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;
    
    // التحقق من وجود بيانات
    if (!data || data.length === 0 || data.every(v => v === 0)) {
        ctx.parentElement.innerHTML = '<div class="no-data">لا توجد بيانات للعرض</div>';
        return;
    }
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: color + '80',
                borderColor: color,
                borderWidth: 2,
                borderRadius: 5,
                hoverBackgroundColor: color
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'العدد: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            family: 'Tahoma'
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            family: 'Tahoma'
                        }
                    }
                }
            }
        }
    });
}

function createLineChart(canvasId, labels, data, color) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;
    
    // التحقق من وجود بيانات
    if (!data || data.length === 0 || data.every(v => v === 0)) {
        ctx.parentElement.innerHTML = '<div class="no-data">لا توجد بيانات للعرض</div>';
        return;
    }
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                borderColor: color,
                backgroundColor: color + '20',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: color,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 10,
                pointHoverBackgroundColor: color
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'العدد: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            family: 'Tahoma'
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            family: 'Tahoma'
                        }
                    }
                }
            }
        }
    });
}

// تصدير الرسم البياني كصورة
function exportChart(chartId, title) {
    const canvas = document.getElementById(chartId);
    if (!canvas) {
        alert('الرسم البياني غير موجود');
        return;
    }
    
    try {
        const image = canvas.toDataURL('image/png');
        const link = document.createElement('a');
        link.download = title + '.png';
        link.href = image;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } catch (e) {
        alert('حدث خطأ أثناء تصدير الصورة');
    }
}

// تصدير PDF
function exportPDF() {
    // استخدام jsPDF لإنشاء PDF
    const { jsPDF } = window.jspdf;
    if (!jsPDF) {
        alert('مكتبة PDF غير محملة');
        return;
    }
    
    const doc = new jsPDF('landscape', 'mm', 'a4');
    
    // إضافة العنوان
    doc.setR2L(true);
    doc.setFont('Tahoma');
    doc.setFontSize(24);
    doc.text('تقرير إحصائيات الموظفين', 14, 22);
    
    doc.setFontSize(12);
    doc.text('تاريخ التقرير: ' + new Date().toLocaleDateString('ar-SA'), 14, 32);
    
    // إضافة الإحصائيات العامة
    let y = 42;
    doc.setFontSize(16);
    doc.text('الإحصائيات العامة', 14, y);
    y += 8;
    
    const statsData = [
        ['البند', 'العدد'],
        ['إجمالي الموظفين', statistics.total_employees],
        ['الذكور', statistics.gender_stats.find(g => g.gender === 'male')?.total || 0],
        ['الإناث', statistics.gender_stats.find(g => g.gender === 'female')?.total || 0],
        ['أخرى', statistics.gender_stats.find(g => g.gender === 'other')?.total || 0]
    ];
    
    doc.autoTable({
        startY: y,
        head: [statsData[0]],
        body: statsData.slice(1),
        theme: 'grid',
        styles: { 
            fontSize: 10,
            font: 'Tahoma',
            halign: 'center'
        },
        headStyles: { 
            fillColor: [52, 73, 94],
            textColor: [255, 255, 255],
            fontSize: 11
        },
        columnStyles: {
            0: { cellWidth: 80 },
            1: { cellWidth: 40 }
        }
    });
    
    // إضافة إحصائيات الحالات
    y = doc.lastAutoTable.finalY + 10;
    doc.setFontSize(16);
    doc.text('إحصائيات الحالات', 14, y);
    y += 8;
    
    const statusData = [
        ['الحالة', 'العدد', 'النسبة']
    ];
    statistics.status_summary.forEach(s => {
        statusData.push([s.label, s.count, s.percentage + '%']);
    });
    
    doc.autoTable({
        startY: y,
        head: [statusData[0]],
        body: statusData.slice(1),
        theme: 'grid',
        styles: { 
            fontSize: 10,
            font: 'Tahoma',
            halign: 'center'
        },
        headStyles: { 
            fillColor: [52, 73, 94],
            textColor: [255, 255, 255],
            fontSize: 11
        },
        columnStyles: {
            0: { cellWidth: 60 },
            1: { cellWidth: 40 },
            2: { cellWidth: 40 }
        }
    });
    
    // إضافة تفاصيل الموظفين
    y = doc.lastAutoTable.finalY + 10;
    doc.setFontSize(16);
    doc.text('تفاصيل الموظفين', 14, y);
    y += 8;
    
    const tableData = document.querySelectorAll('#employeesTable tbody tr');
    const tableRows = [];
    tableData.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 9) {
            tableRows.push([
                cells[1].textContent.trim(),
                cells[2].textContent.trim(),
                cells[3].textContent.trim(),
                cells[4].textContent.trim(),
                cells[5].textContent.trim(),
                cells[6].textContent.trim(),
                cells[7].textContent.trim(),
                cells[8].textContent.trim()
            ]);
        }
    });
    
    doc.autoTable({
        startY: y,
        head: [['الاسم', 'النوع', 'الحالة', 'المركز', 'الصالة', 'الرتبة', 'الجنسية', 'سنة التسجيل']],
        body: tableRows,
        theme: 'grid',
        styles: { 
            fontSize: 7,
            font: 'Tahoma',
            halign: 'center'
        },
        headStyles: { 
            fillColor: [52, 73, 94],
            textColor: [255, 255, 255],
            fontSize: 8
        },
        columnStyles: {
            0: { cellWidth: 30 },
            1: { cellWidth: 20 },
            2: { cellWidth: 25 },
            3: { cellWidth: 25 },
            4: { cellWidth: 25 },
            5: { cellWidth: 20 },
            6: { cellWidth: 25 },
            7: { cellWidth: 20 }
        }
    });
    
    doc.save('تقرير_الموظفين.pdf');
}

// تصدير Excel
function exportExcel() {
    const table = document.getElementById('employeesTable');
    if (!table) return;
    
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    // إضافة عنوان التقرير
    csv.push('تقرير إحصائيات الموظفين');
    csv.push('تاريخ التقرير: ' + new Date().toLocaleDateString('ar-SA'));
    csv.push('');
    
    // إضافة رؤوس الأعمدة
    const headers = [];
    const headerRow = rows[0];
    if (headerRow) {
        headerRow.querySelectorAll('th').forEach(th => {
            headers.push(th.textContent.trim());
        });
    }
    csv.push(headers.join(','));
    
    // إضافة البيانات
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const rowData = [];
        row.querySelectorAll('td').forEach(td => {
            // تنظيف النص من العلامات
            let text = td.textContent.trim();
            // إزالة المسافات الزائدة
            text = text.replace(/\s+/g, ' ');
            rowData.push('"' + text + '"');
        });
        csv.push(rowData.join(','));
    }
    
    // إنشاء ملف CSV مع دعم اللغة العربية
    const blob = new Blob(['\uFEFF' + csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'تقرير_الموظفين.csv';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// تحديث الإحصائيات تلقائياً (اختياري)
function refreshStatistics() {
    location.reload();
}

// عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    // تأثيرات الحركة للبطاقات
    const cards = document.querySelectorAll('.stats-card, .status-card, .chart-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = (index * 0.1) + 's';
    });
});