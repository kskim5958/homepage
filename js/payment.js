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
                const list_sum = data.list_sum;
                console.log("🚀 ~ list_sum:", list_sum)
                const today = data.today;
                const html = fn_payment_list_html(list, list_sum, today);
                $("#daily_today").append(html);
            }
        },
        error: function () {
            alert("파일 읽기 실패");
        },
    });
});

const fn_payment_list_html = (list, list_sum, today) => {
    let html = "";
    html += "<table>";
    html += 
    `<thead>
        <tr class="today__date">
            <th colspan="12">${today} 오늘의일계표</th>
        </tr>
        <tr class="title">
            <th rowspan="2">순번</th>
            <th rowspan="2" colspan="2">성명</th>
            <th colspan="3">보험수납</th>
            <th colspan="3">비보험수납</th>
            <th rowspan="2">합계</th>
            <th rowspan="2">진료내역</th>
        </tr>
        <tr class="title">
            <th>카드</th>
            <th>현금</th>
            <th>계좌이체</th>
            <th>카드</th>
            <th>현금</th>
            <th>계좌이체</th>
        </tr>
    </thead>`;
    html += "<tbody>";
    $.each(list, function(index, arr) {
        html += "<tr>";
        html += `<td name="num">${index}</td>`;
        html += `<td name="name" colspan="2">${arr.name}</td>`;
        html += `<td class="pay__format" name="ins_card">${arr.ins_card}</td>`;
        html += `<td class="pay__format" name="ins_cash">${arr.ins_cash}</td>`;
        html += `<td class="pay__format" name="ins_online">${arr.ins_online}</td>`;
        html += `<td class="pay__format" name="unins_card">${arr.unins_card}</td>`;
        html += `<td class="pay__format" name="unins_cash">${arr.unins_cash}</td>`;
        html += `<td class="pay__format" name="unins_online">${arr.unins_online}</td>`;
        html += `<td class="pay__format" name="payment_sum">${arr.payment_sum}</td>`;
        html += `<td name="content">${arr.content}</td>`;
        html += "</tr>";
    });
    html += "<tr>";
    html += "<td></td>";
    html += `<td name="name" colspan="2"></td>`;
    html += `<td class="pay__format" name="ins_card_sum">${list_sum.ins_card_sum}</td>`;
    html += `<td class="pay__format" name="ins_cash_sum">${list_sum.ins_cash_sum}</td>`;
    html += `<td class="pay__format" name="ins_online_sum">${list_sum.ins_online_sum}</td>`;
    html += `<td class="pay__format" name="unins_card_sum">${list_sum.unins_card_sum}</td>`;
    html += `<td class="pay__format" name="unins_cash_sum">${list_sum.unins_cash_sum}</td>`;
    html += `<td class="pay__format" name="unins_online_sum">${list_sum.unins_online_sum}</td>`;
    html += `<td class="pay__format" name="total_sum">${list_sum.total_sum}</td>`;
    html += "<td></td>";
    html += "</tr>";
    html += "</tbody>";
    html += "</table>";
    return html;
}
