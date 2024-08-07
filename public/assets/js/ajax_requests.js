$(function () {
    //! Get Subscribers With Ajax
    let table = $("#subscribersTable").DataTable({
        paging: true,
        scrollY: 400,
        ordering: true,
        autoWidth: true,
        searching: true,
        pageLength: 20,
        pagingTag: "button",
        pagingType: "simple_numbers",
        deferRender: true,
        // processing: true,
        // serverSide: true,
        ajax: "{{ route('subscribers.all') }}",
        columns: [
            { data: "member_id", name: "member_id" },
            { data: "name", name: "name" },
            { data: "nickname", name: "nickname" },
            { data: "ssn", name: "ssn" },
            { data: "address", name: "address" },
            {
                data: "educational_qualification",
                name: "educational_qualification",
            },
            { data: "qualification_date", name: "qualification_date" },
            { data: "job", name: "job" },
            { data: "job_destination", name: "job_destination" },
            { data: "job_tel", name: "job_tel" },
            { data: "job_address", name: "job_address" },
            { data: "home_tel", name: "home_tel" },
            { data: "martial_status", name: "martial_status" },
            { data: "birthdate", name: "birthdate" },
            { data: "mobile_no", name: "mobile_no" },
            { data: "membership_type", name: "membership_type" },
            { data: "id_img", name: "id_img" },
            { data: "status", name: "status" },
        ],
    });
    console.log(table);
});
