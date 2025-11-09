      <?php  
	  $HeadScript = "let autosave = false;
        let minimized = false;
        let filterSetup = false;
        let editingId = null;
        
        document.getElementById('autosaveToggle').addEventListener('click', function() {
            autosave = !autosave;
            this.classList.toggle('active');
            document.getElementById('autosaveStatus').textContent = autosave ? '✓ Autosave enabled' : '✗ Autosave disabled';
            document.getElementById('autosaveStatus').classList.toggle('active', autosave);
        });
        
        document.getElementById('minimizeToggle').addEventListener('click', function() {
            minimized = !minimized;
            this.classList.toggle('active');
            document.getElementById('minimizeStatus').textContent = minimized ? '✓ Minimized' : '✗ Expanded';
            document.getElementById('minimizeStatus').classList.toggle('active', minimized);
            document.getElementById('tableContent').classList.toggle('hidden', minimized);
            document.getElementById('minimizedContent').classList.toggle('hidden', !minimized);
        });
        
        document.getElementById('filterToggle').addEventListener('click', function() {
            filterSetup = !filterSetup;
            this.classList.toggle('active');
            document.getElementById('filterStatus').textContent = filterSetup ? '✓ Filter setup active' : '✗ Filter setup inactive';
            document.getElementById('filterStatus').classList.toggle('active', filterSetup);
            document.getElementById('filterRow').classList.toggle('hidden', !filterSetup);
        });
        
        
        ['filterID', 'filterName', 'filterEmail', 'filterStatus'].forEach(id => {
            document.getElementById(id).addEventListener('input', applyFilters);
        });
        
        function applyFilters() {
            const filters = {
                id: document.getElementById('filterID').value.toLowerCase(),
                name: document.getElementById('filterName').value.toLowerCase(),
                email: document.getElementById('filterEmail').value.toLowerCase(),
                status: document.getElementById('filterStatus').value.toLowerCase()
            };
            
            document.querySelectorAll('#tableBody tr').forEach(row => {
                const id = row.cells[0].textContent.toLowerCase();
                const name = row.querySelector('.name-cell').textContent.toLowerCase();
                const email = row.querySelector('.email-cell').textContent.toLowerCase();
                const status = row.querySelector('.status-cell').textContent.toLowerCase();
                
                const match = id.includes(filters.id) && 
                             name.includes(filters.name) && 
                             email.includes(filters.email) && 
                             status.includes(filters.status);
                
                row.style.display = match ? '' : 'none';
            });
        }
        
        function addRow() {
            fetch('', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'action=add'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
        
        function editRow(id) {
            editingId = id;
            const row = document.querySelector(`tr[data-id=\"${id}\"]`);
            const name = row.querySelector('.name-cell').textContent;
            const email = row.querySelector('.email-cell').textContent;
            const statusBadge = row.querySelector('.status-badge');
            const status = statusBadge.textContent.trim();
            
            row.querySelector('.name-cell').innerHTML = `<input type=\"text\" class=\"edit-input\" value=\"${name}\" id=\"edit-name-${id}\">`;
            row.querySelector('.email-cell').innerHTML = `<input type=\"email\" class=\"edit-input\" value=\"${email}\" id=\"edit-email-${id}\">`;
            row.querySelector('.status-cell').innerHTML = `
                <select class=\"edit-select\" id=\"edit-status-${id}\">
                    <option value=\"Active\" ${status === 'Active' ? 'selected' : ''}>Active</option>
                    <option value=\"Inactive\" ${status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                    <option value=\"Pending\" ${status === 'Pending' ? 'selected' : ''}>Pending</option>
                </select>
            `;
            row.cells[4].innerHTML = `
                <button class=\"btn btn-save\" onclick=\"saveRow(${id})\">
                    <svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"/>
                    </svg>
                    Save
                </button>
                <button class=\"btn btn-cancel\" onclick=\"cancelEdit(${id})\">
                    <svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M6 18L18 6M6 6l12 12\"/>
                    </svg>
                    Cancel
                </button>
            `;
        }
        
        function saveRow(id) {
            const name = document.getElementById(`edit-name-${id}`).value;
            const email = document.getElementById(`edit-email-${id}`).value;
            const status = document.getElementById(`edit-status-${id}`).value;
            
            fetch('', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `action=update&id=${id}&name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&status=${encodeURIComponent(status)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
        
        function cancelEdit(id) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const isEmpty = !row.querySelector(`#edit-name-${id}`).value && 
                           !row.querySelector(`#edit-email-${id}`).value;
            
            if (isEmpty) {
                fetch('', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `action=delete&id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            } else {
                location.reload();
            }
        }";
	?>	