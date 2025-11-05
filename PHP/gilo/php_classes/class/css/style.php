<?php $StyleString = "{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
            padding: 2rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(to right, #2563eb, #1d4ed8);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .header h2 {
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
        }
        
        .toggles {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        
        .toggle-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .toggle-item label {
            color: white;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .toggle-switch {
            position: relative;
            width: 44px;
            height: 24px;
            background: #9ca3af;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .toggle-switch.active {
            background: #60a5fa;
        }
        
        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            background: white;
            border-radius: 50%;
            top: 4px;
            left: 4px;
            transition: transform 0.3s;
        }
        
        .toggle-switch.active::after {
            transform: translateX(20px);
        }
        
        .status-bar {
            background: #f9fafb;
            padding: 0.5rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            gap: 1rem;
            font-size: 0.875rem;
        }
        
        .status-item {
            color: #6b7280;
        }
        
        .status-item.active {
            color: #059669;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead tr {
            background: #f3f4f6;
        }
        
        th {
            padding: 0.75rem 1.5rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        td {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            font-size: 0.875rem;
        }
        
        tbody tr:hover {
            background: #f9fafb;
        }
        
        .filter-row input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 0.875rem;
        }
        
        .filter-row input:focus {
            outline: none;
            border-color: #2563eb;
            ring: 2px solid #93c5fd;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-active {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .edit-input {
            width: 100%;
            padding: 0.25rem 0.5rem;
            border: 1px solid #2563eb;
            border-radius: 4px;
            font-size: 0.875rem;
        }
        
        .edit-select {
            width: 100%;
            padding: 0.25rem 0.5rem;
            border: 1px solid #2563eb;
            border-radius: 4px;
            font-size: 0.875rem;
        }
        
        .btn {
            padding: 0.5rem 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            transition: all 0.2s;
        }
        
        .btn-save {
            background: #059669;
            color: white;
        }
        
        .btn-save:hover {
            background: #047857;
        }
        
        .btn-cancel {
            background: #dc2626;
            color: white;
        }
        
        .btn-cancel:hover {
            background: #b91c1c;
        }
        
        .btn-edit {
            background: transparent;
            color: #2563eb;
            font-weight: 600;
        }
        
        .btn-edit:hover {
            color: #1d4ed8;
        }
        
        .btn-add {
            background: #2563eb;
            color: white;
            padding: 0.5rem 1rem;
        }
        
        .btn-add:hover {
            background: #1d4ed8;
        }
        
        .footer {
            padding: 1rem 1.5rem;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }
        
        .minimized-text {
            padding: 3rem 1.5rem;
            text-align: center;
            color: #6b7280;
        }
        
        .hidden {
            display: none;
        }
.css-button {
	color: #FFFFFF;
	font-size: 16px;
	border-radius: 5px;
	border: solid 1px #3866a3;
	text-shadow: 1px 1px 0px #528ECC;
	box-shadow: inset 1px 1px 0px 0px #BBDAF7;
	text-decoration: none;
	cursor: pointer;
	position: relative;
	overflow: hidden;
	font-family: Arial;
	background: linear-gradient(180deg, #63B8EE 10%, #468CCF 100%);
	display: inline-flex;
	align-items: center;
	padding: 0;
}
.css-button:hover {
	background: linear-gradient(180deg, #468CCF 10%, #63B8EE 100%);
}
.css-button-text {
	position: relative;
	padding: 10px 18px;
}
.css-button-icon {
	position: relative;
	border-right: 1px solid #ffffff29;
	box-shadow: inset rgb(0 0 0 / 14%) -1px 0 0;
	padding: 10px 10px;
}";
?>