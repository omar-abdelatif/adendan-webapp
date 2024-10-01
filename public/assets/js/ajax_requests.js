$(function () {
    //! Get Subscribers With Ajax
    //! Get Subscribers Via Ajax
    let imageBaseUrl = $("#subscribers_table").data("image-url");
    let idImageBaseUrl = $("#subscribers_table").data("id-image-url");
    let ajax = $("#subscribers_table").DataTable({
        ajax: { url: "ajax/data/subscribers" },
        processing: true,
        serverSide: true,
        order: [[0, "asc"]],
        columns: [
            {
                data: "#",
                title: "#",
                className: "dt-control",
                orderable: false,
                defaultContent: "",
            },
            { data: "member_id", title: "رقم العضوية" },
            { data: "name", title: "الإسم" },
            {
                data: "img",
                title: "صورة شخصية",
                className: "rounded",
                render: function (data, type, row) {
                    if (row.img === null) {
                        return `غير موجودة`;
                    } else {
                        return `<img src="${imageBaseUrl}/${row.img}" class="img-fluid rounded" style="width: 80px;" alt="صورة شخصية"/>`;
                    }
                },
            },
            {
                data: "id_img",
                title: "صورة البطاقة الشخصية",
                className: "rounded",
                render: function (data, type, row) {
                    if (row.id_img === null) {
                        return `غير موجودة`;
                    } else {
                        return `<img src="${idImageBaseUrl}/${row.id_img}" class="img-fluid rounded" style="width: 80px;" alt="صورة البطاقة الشخصية"/>`;
                    }
                },
            },
            {
                data: "status",
                title: "حالة الإشتراك",
                render: function (data, type, row) {
                    if (row.status === 2) {
                        return `<span class="fw-bold badge badge-light-dark px-3 py-1 rounded-pill">المشترك متوفي</span>`;
                    } else {
                        return `<span class="fw-bold badge badge-light-success px-3 py-1 rounded-pill">الإشتراك مفعل</span>`;
                    }
                },
            },
            { data: "Actions", title: "Actions", orderable: false },
        ],
    });
    function details(d) {
        return `
            <div class="subscribers-content">
                <div class="subscribers-details d-flex align-items-center justify-content-evenly flex-wrap">
                    <div class="subscribers-mobile mb-3">
                        <span class="fw-bold">رقم المحمول: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.mobile_no}</span>
                    </div>
                    <div class="subscribers-address mb-3">
                        <span class="fw-bold">العنوان: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.address}</span>
                    </div>
                    <div class="subscribers-job mb-3">
                        <span class="fw-bold">الوظيفة: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.job}</span>
                    </div>
                    <div class="subscribers-birthDate mb-3">
                        <span class="fw-bold">تاريخ الميلاد: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.birthdate}</span>
                    </div>
                    <div class="subscribers-nickname mb-3">
                        <span class="fw-bold">اللقب: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.nickname}</span>
                    </div>
                    <div class="subscribers-ssn mb-3">
                        <span class="fw-bold">الرقم القومي: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.ssn}</span>
                    </div>
                    <div class="subscribers-membershipType mb-3">
                        <span class="fw-bold">نوع العضوية: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.membership_type}</span>
                    </div>
                    <div class="subscribers-homeTel mb-3">
                        <span class="fw-bold">تلفون المنزل: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.home_tel}</span>
                    </div>
                    <div class="subscribers-jobTel mb-3">
                        <span class="fw-bold">تلفون العمل: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.job_tel}</span>
                    </div>
                    <div class="subscribers-martialStatus mb-3">
                        <span class="fw-bold">المؤهل الدراسي: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.educational_qualification}</span>
                    </div>
                    <div class="subscribers-member_id mb-3">
                        <span class="fw-bold">تاريخ المؤهل: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.qualification_date}</span>
                    </div>
                    <div class="subscribers-member_id mb-3">
                        <span class="fw-bold">مكان الوظيفة: </span>
                        <span class="badge-light-primary rounded-pill text-center px-3 py-1">${d.job_address}</span>
                    </div>
                </div>
            </div>
        `;
    }
    ajax.on("click", "td.dt-control", function (e) {
        let tr = e.target.closest("tr");
        let row = ajax.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
        } else {
            row.child(details(row.data())).show();
        }
    });
});
