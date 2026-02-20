$('[name="upload_btn"]').click(function (e) { 
    e.preventDefault();
    const form = $(this).data("form");
    const file = $(".form").find(`[name="${form}"]`);
    const file_data = file.prop('files')[0];
    const form_data = new FormData();
    form_data.append('file', file_data);

    $.ajax({
        url: "/php/excel/upload.php",
        type: "POST",
        data: form_data,
        contentType: false,
        processData: false,
        success: function (data) {
            data = JSON.parse(data);
            const result = data.result;
            if (result) {
                const list = data.list;
                const today = data.today;
                const html = fn_payment_list_html(list, today);
                $("#result_area").append(html);
            }
        },
        error: function () {
            alert("파일 읽기 실패");
        },
    });
});

const fn_payment_list_html = (list, today) => {
    let html = "";
    html += "<table>";
    html += 
    `<thead>
        <tr>
            <th colspan="12">${today}</th>
        </tr>
        <tr>
            <th rowspan="2">순번</th>
            <th rowspan="2" colspan="2">성명</th>
            <th colspan="3">보험수납</th>
            <th colspan="3">비보험수납</th>
            <th rowspan="2">합계</th>
            <th rowspan="2">진료내역</th>
        </tr>
        <tr>
            <th>현금</th>
            <th>카드</th>
            <th>계좌이체</th>
            <th>현금</th>
            <th>카드</th>
            <th>계좌이체</th>
        </tr>
    </thead>`;
    html += "<tbody>";
    $.each(list, function(index, arr) {
        html += "<tr>";
        html += `<td>${index}</td>`;
        html += `<td colspan="2">${arr.name}</td>`;
        html += `<td>${arr.ins_card}</td>`;
        html += `<td>${arr.ins_cash}</td>`;
        html += `<td>${arr.ins_online}</td>`;
        html += `<td>${arr.unins_card}</td>`;
        html += `<td>${arr.unins_cash}</td>`;
        html += `<td>${arr.unins_online}</td>`;
        html += `<td>${arr.payment_sum}</td>`;
        html += `<td>${arr.content}</td>`;
        html += "</tr>";
    });
    html += "</tbody>";
    html += "</table>";
    return html;
}
