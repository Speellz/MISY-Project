function viewData(page = 1) {
    const viewType = document.getElementById('viewType').value;
    const formData = new FormData();
    formData.append('viewType', viewType);
    formData.append('page', page);

    fetch('view_data.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json(); // json olarak al
    })
    .then(data => {
        const viewResult = document.getElementById('viewResult');
        viewResult.innerHTML = '';

        if (data && data.data && data.data.length > 0) { // veri var mı kontrol et
            const table = document.createElement('table');
            const thead = document.createElement('thead');
            const tbody = document.createElement('tbody');

            const headers = Object.keys(data.data[0]);
            const tr = document.createElement('tr');
            headers.forEach(header => {
                if (header !== 'row_num') { // row_num özelliğini atla
                    const th = document.createElement('th');
                    th.textContent = header.charAt(0).toUpperCase() + header.slice(1);
                    tr.appendChild(th);
                }
            });
            thead.appendChild(tr);
            table.appendChild(thead);

            data.data.forEach(item => {
                const tr = document.createElement('tr');
                headers.forEach(header => {
                    if (header !== 'row_num') { // row_num özelliğini atla
                        const td = document.createElement('td');
                        if (header === 'duration' && typeof item[header] === 'object') {
                            const duration = item[header];
                            const hours = String(duration.hours).padStart(2, '0');
                            const minutes = String(duration.minutes).padStart(2, '0');
                            const seconds = String(duration.seconds).padStart(2, '0');
                            td.textContent = `${hours}:${minutes}:${seconds}`;
                        } else {
                            td.textContent = item[header];
                        }
                        tr.appendChild(td);
                    }
                });
                tbody.appendChild(tr);
            });
            table.appendChild(tbody);

            viewResult.appendChild(table);

            // sayfalama
            const totalPages = Math.ceil(data.totalCount / 10);
            const pagination = document.createElement('div');
            pagination.className = 'pagination';

            if (page > 1) {
                const prevLink = document.createElement('a');
                prevLink.href = "#";
                prevLink.textContent = "«";
                prevLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    viewData(page - 1);
                });
                pagination.appendChild(prevLink);
            }

            for (let i = 1; i <= totalPages; i++) {
                const pageLink = document.createElement('a');
                pageLink.href = "#";
                pageLink.textContent = i;
                if (i === page) {
                    pageLink.className = 'active';
                }
                pageLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    viewData(i);
                });
                pagination.appendChild(pageLink);
            }

            if (page < totalPages) {
                const nextLink = document.createElement('a');
                nextLink.href = "#";
                nextLink.textContent = "»";
                nextLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    viewData(page + 1);
                });
                pagination.appendChild(nextLink);
            }

            viewResult.appendChild(pagination);
        } else {
            viewResult.textContent = 'No data found.';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const viewResult = document.getElementById('viewResult');
        viewResult.textContent = 'An error occurred while fetching data.';
    });
}

document.getElementById('viewType').addEventListener('change', function() {
    viewData(1);
});
