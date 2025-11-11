<?PHP 
session_start();
//include "html.html";
//include "class\css\Skins.html";
include "class\include\document.php";
//include "class\css\style.php";
$State = ["view"=>"Dashboard",
          "theme"=>"dark",
          "selectedMachine"=>null,
          "selectedSensor"=>null,
          "diagnosis"=>null,
          "deviceTab"=>"list",
          "liveMonitoringInterval"=>null];
$CompanyName = "Gilo Telematry Industries";
$UserName  = "Gift Shipalana";
$DashboardIcon = "⚙️";
$DashboardName = "IoT Smart View ";
$UserMenu = "Dashboard,Live Monitoring,Error Reports,Device Management,Settings,Profile";
$StyleString = '
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --color-primary: #3b82f6;
            --color-success: #10b981;
            --color-warning: #f59e0b;
            --color-danger: #ef4444;
            --color-bg: #ffffff;
            --color-surface: #f9fafb;
            --color-border: #e5e7eb;
            --color-text: #111827;
            --color-text-secondary: #6b7280;
        }
 .machine-info {
            margin: 15px 0;
        }
        [data-theme="dark"] {
            --color-bg: #111827;
            --color-surface: #1f2937;
            --color-border: #374151;
            --color-text: #f9fafb;
            --color-text-secondary: #9ca3af;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--color-bg);
            color: var(--color-text);
            transition: background 0.3s, color 0.3s;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: var(--color-surface);
            border-right: 1px solid var(--color-border);
            padding: 1.5rem;
            transition: background 0.3s;
        }
		.user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #7f8c8d;
			center
        }
        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--color-text-secondary);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .nav-item a:hover,
        .nav-item a.active {
            background: var(--color-primary);
            color: white;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-border);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
        }

        .toggle-switch-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--color-primary);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        .category-section {
            margin-bottom: 2rem;
        }

        .category-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .category-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-icon svg {
            width: 28px;
            height: 28px;
        }

        .machine-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .machine-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            transition: all 0.3s;
        }

        .machine-card:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .machine-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .connection-status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .connection-status-dot.online {
            background: var(--color-success);
        }

        .connection-status-dot.offline {
            background: var(--color-text-secondary);
            animation: none;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-badge.normal {
            background: #10b98120;
            color: var(--color-success);
        }

        .status-badge.warning {
            background: #f59e0b20;
            color: var(--color-warning);
        }

        .status-badge.critical,
        .status-badge.error {
            background: #ef444420;
            color: var(--color-danger);
        }

        .machine-icon-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--color-text-secondary);
        }

        .machine-icon-container svg {
            width: 20px;
            height: 20px;
        }

        .card-actions {
            margin-top: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--color-primary);
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-secondary {
            background: var(--color-surface);
            color: var(--color-text);
            border: 1px solid var(--color-border);
        }

        .btn-secondary:hover {
            background: var(--color-border);
        }

        .btn-danger {
            background: var(--color-danger);
            color: white;
        }

        .monitoring-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .sensor-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .sensor-card:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .sensor-label {
            font-size: 0.875rem;
            color: var(--color-text-secondary);
            margin-bottom: 0.5rem;
        }

        .sensor-value {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .threshold-bar {
            height: 8px;
            background: var(--color-border);
            border-radius: 4px;
            overflow: hidden;
        }

        .threshold-fill {
            height: 100%;
            transition: width 0.3s;
        }

        .threshold-fill.normal {
            background: var(--color-success);
        }

        .threshold-fill.warning {
            background: var(--color-warning);
        }

        .threshold-fill.critical {
            background: var(--color-danger);
        }

        .live-monitor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .connection-status-badge {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.875rem;
        }

        .connection-status-badge.online {
            background: #10b98120;
            color: var(--color-success);
        }

        .connection-status-badge.offline {
            background: #6b728020;
            color: var(--color-text-secondary);
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: var(--color-surface);
            border-radius: 1rem;
            padding: 2rem;
            max-width: 700px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-close-btn {
            background: none;
            border: none;
            font-size: 2rem;
            cursor: pointer;
            color: var(--color-text-secondary);
        }

        .modal-body {
            margin-top: 1rem;
        }

        .modal-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .chart-container {
            margin-top: 1rem;
            background: var(--color-bg);
            padding: 1rem;
            border-radius: 0.5rem;
        }

        .chart-container svg {
            width: 100%;
            height: auto;
        }

        .grid-line {
            stroke: var(--color-border);
            stroke-width: 1;
        }

        .axis-label {
            fill: var(--color-text-secondary);
            font-size: 10px;
        }

        .area {
            fill: var(--color-primary);
            opacity: 0.2;
        }

        .line {
            fill: none;
            stroke: var(--color-primary);
            stroke-width: 2;
        }

        .table-container {
            overflow-x: auto;
            background: var(--color-surface);
            border-radius: 0.75rem;
            border: 1px solid var(--color-border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--color-border);
        }

        th {
            background: var(--color-bg);
            font-weight: 600;
        }

        .form-section {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 0.75rem;
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--color-border);
            border-radius: 0.5rem;
            background: var(--color-bg);
            color: var(--color-text);
            font-size: 1rem;
        }

        .history-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1rem;
        }

        .settings-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .tab-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            background: var(--color-surface);
            color: var(--color-text);
            cursor: pointer;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .tab-btn.active {
            background: var(--color-primary);
            color: white;
        }

        .print-hide {
            display: block;
        }

        @media print {
            .print-hide {
                display: none;
            }
        }
    ';
		
$HtmlHead =  new DocHead();

$HtmlDoc = New HtmlDoc();
$HtmlDoc->AddAttrib("lang","en");

/*Add Elements to the Head Element */
$Meta = new Meta();
$Meta->AddAttrib("charset","UTF-8");
$Meta->AddAttrib("name","viewport");
$Meta->AddAttrib("content","width=device-width");
$Meta->AddAttrib("initial-scale","1.0");
$HtmlHead->AddElement($Meta);

/*Add Title to the head */
$Title =  new Title("Smart IoT Dashboard");
$HtmlHead->AddElement($Title);$Style =  new Style($StyleString);
$HtmlHead->AddElement($Style);

//Add Head element to the html doc
$HtmlDoc->AddElement($HtmlHead);
$HtmlBody = new HtmlBody();
/*Add code to choose theme from user preference*/

$HtmlBody->AddAttrib("data-theme",$State["theme"]);
$HtmlBody->AddAttrib("onload","AddToggleEvent(); AddDataViewEvents();");
$Script = new Script("
 const HEARTBEAT_TIMEOUT = 15000;
	    let state = {
            view: 'Dashboard',
            theme: 'dark',
            selectedMachine: null,
            selectedSensor: null,
            diagnosis: null,
            deviceTab: 'list',
            liveMonitoringInterval: null,
            kafkaMessages: [
                { id: 1, message_id: 'msg-swh001-001', machine_id: 'SWH001', kafka_topic: 'machine-readings', kafka_partition: 0, kafka_offset: 12345, message_timestamp: '2024-11-05 10:00:00', message_hash: 'abc123def456', processed_at: '2024-11-05 10:00:01', processing_status: 'processed', reading_id: 1, error_message: null },
                { id: 2, message_id: 'msg-swh001-002', machine_id: 'SWH001', kafka_topic: 'machine-readings', kafka_partition: 0, kafka_offset: 12346, message_timestamp: '2024-11-05 10:05:00', message_hash: 'def456ghi789', processed_at: '2024-11-05 10:05:01', processing_status: 'processed', reading_id: 2, error_message: null },
                { id: 3, message_id: 'msg-swh001-003', machine_id: 'SWH001', kafka_topic: 'machine-readings', kafka_partition: 0, kafka_offset: 12347, message_timestamp: '2024-11-05 10:10:00', message_hash: 'ghi789jkl012', processed_at: '2024-11-05 10:10:02', processing_status: 'failed', reading_id: null, error_message: 'Invalid data format' },
                { id: 4, message_id: 'msg-swh001-004', machine_id: 'SWH001', kafka_topic: 'machine-readings', kafka_partition: 0, kafka_offset: 12348, message_timestamp: '2024-11-05 10:15:00', message_hash: 'abc123def456', processed_at: '2024-11-05 10:15:01', processing_status: 'skipped', reading_id: null, error_message: 'Duplicate message detected' },
            ],
            users: [
                { id: 1, name: 'Admin User', email: 'admin@example.com', role: 'admin', status: 'active' },
                { id: 2, name: 'Regular User', email: 'user@example.com', role: 'user', status: 'active' },
            ],
            currentUser: { id: 1, name: 'Admin User', email: 'admin@example.com', role: 'admin', status: 'active' },
            categories: [
                { id: 1, category_name: 'Solar Water Heaters', category_code: 'SWH', description: 'AI-controlled solar water heating systems.', icon: 'M12 3.5c-1.2 0-2.3.4-3.2 1.1L12 8l3.2-3.4c-.9-.7-2-1.1-3.2-1.1z M12 20.5c1.2 0 2.3-.4 3.2-1.1L12 16l-3.2 3.4c.9.7 2 1.1 3.2 1.1z M5.1 6.3C4.4 7.2 4 8.3 4 9.5s.4 2.3 1.1 3.2l3.4-3.2L5.1 6.3zm13.8 0l-3.4 3.2 3.4 3.2c.7-.9 1.1-2 1.1-3.2s-.4-2.3-1.1-3.2z M12 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z', color: '#f59e0b' },
            ],
            machines: [
                { id: 1, machine_id: 'SWH001', name: 'Main Heater Unit', category_id: 1, location: 'Rooftop Sector 1', status: 'normal', lastHeartbeat: Date.now(), model: 'SWH-2000', manufacturer: 'SolarTech', serial_number: 'SN-2024-001', installed_at: '2024-01-15' },
            ],
            valueCategories: [
                { id: 1, value_name: 'Collector Temperature', value_code: 'collector_temp', unit: '°C', data_type: 'decimal' },
                { id: 2, value_name: 'Tank Temperature', value_code: 'tank_temp', unit: '°C', data_type: 'decimal' },
                { id: 3, value_name: 'Pump State', value_code: 'pump_state', unit: '', data_type: 'boolean' },
                { id: 4, value_name: 'Pump Speed', value_code: 'pump_speed', unit: '%', data_type: 'integer' },
                { id: 5, value_name: 'Flow Rate', value_code: 'flow_rate', unit: 'L/min', data_type: 'decimal' },
            ],
            thresholds: [
                { id: 1, value_category_id: 1, min_value: 0, max_value: 150, warning_min: 10, warning_max: 120, critical_min: 5, critical_max: 135, warning_error_id: 1, critical_error_id: 2 },
                { id: 2, value_category_id: 2, min_value: 0, max_value: 100, warning_min: 15, warning_max: 85, critical_min: 10, critical_max: 95, warning_error_id: 3, critical_error_id: 4 },
                { id: 3, value_category_id: 5, min_value: 0, max_value: 20, warning_min: 2, warning_max: 18, critical_min: 1, critical_max: 19, warning_error_id: 5, critical_error_id: 6 },
            ],
            errorTypes: [
                { id: 1, error_code: 'WARN_COLL_TEMP', error_name: 'Collector Temp Warning', severity: 'warning', description: 'Temperature approaching warning threshold', recommended_action: 'Monitor temperature and check cooling system' },
                { id: 2, error_code: 'CRIT_COLL_TEMP', error_name: 'Collector Overheating', severity: 'critical', description: 'Critical temperature exceeded', recommended_action: 'Shut down immediately and inspect cooling system' },
                { id: 3, error_code: 'WARN_TANK_TEMP', error_name: 'Tank Temp Warning', severity: 'warning', description: 'Tank temperature warning', recommended_action: 'Check thermostat settings' },
                { id: 4, error_code: 'CRIT_TANK_TEMP', error_name: 'Tank Overheating', severity: 'critical', description: 'Tank critical temperature', recommended_action: 'Emergency shutdown required' },
                { id: 5, error_code: 'WARN_FLOW_RATE', error_name: 'Low Flow Rate', severity: 'warning', description: 'Flow rate below optimal', recommended_action: 'Check for blockages' },
                { id: 6, error_code: 'CRIT_FLOW_RATE', error_name: 'No Flow Detected', severity: 'critical', description: 'Critical flow failure', recommended_action: 'Inspect pump and valves immediately' },
            ],
            errors: [],
            readings: [],
        };

		function AddDataViewEvents(){
		document.querySelectorAll('[data-view]').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    state.view = link.dataset.view;
                    render();
                });
            });
			}
			function stopLiveMonitoring() {
            if (state.liveMonitoringInterval) {
                clearInterval(state.liveMonitoringInterval);
                state.liveMonitoringInterval = null;
            }
        }
			function render() {
            
            // Stop live monitoring when leaving Live Monitoring view
            if (state.view !== 'Live Monitoring') {
                stopLiveMonitoring();
            }

            switch(state.view) {
                case 'Dashboard':
                    renderDashboard();
                    break;
                case 'Live Monitoring':
                    renderLiveMonitoring();
                    break;
                case 'Reports':
                    renderReports();
                    break;
                case 'Device Management':
                    renderDeviceManagement();
                    break;
                case 'Settings':
                    renderSettings();
                    break;
            }
        }".
		  'function renderDashboard() {
            const groupedMachines = {};
			const machineCategories = [
            { id: 1, category_name: "Manufacturing Equipment", category_code: "MFG", icon: "🏭", color: "#3498db" },
            { id: 2, category_name: "HVAC Systems", category_code: "HVAC", icon: "❄️", color: "#2ecc71" },
            { id: 3, category_name: "Security Systems", category_code: "SEC", icon: "🔒", color: "#e74c3c" },
            { id: 4, category_name: "Energy Management", category_code: "ENR", icon: "⚡", color: "#f39c12" }
        ];
		// Sample machines based on database schema
        const Machines = [
            {
                machine_id: "MFG-001",
                machine_name: "Production Line A",
                category_id: 1,
                category: "Manufacturing Equipment",
                location: "Factory Floor 1",
                model: "PL-2000X",
                manufacturer: "IndustrialTech",
                serial_number: "IT-PL-2023-001",
                status: "normal",
                installed_at: "2023-01-15",
                last_maintenance: "2024-01-10",
                next_maintenance: "2024-04-10",
                sensors: [
                    { value_category_id: 1, name: "Temperature", current_value: 72, unit: "°F", warning_min: 65, warning_max: 85, critical_min: 60, critical_max: 90 },
                    { value_category_id: 2, name: "Pressure", current_value: 45, unit: "PSI", warning_min: 35, warning_max: 55, critical_min: 30, critical_max: 60 },
                    { value_category_id: 4, name: "Vibration", current_value: 0.2, unit: "mm/s", warning_min: 0, warning_max: 0.5, critical_min: 0, critical_max: 1.0 }
                ],
                errors: 0,
                lastUpdated: new Date().toISOString()
            },
            {
                machine_id: "HVAC-002",
                machine_name: "HVAC Unit B",
                category_id: 2,
                category: "HVAC Systems",
                location: "Building 2 - Floor 3",
                model: "AC-5000",
                manufacturer: "ClimateControl Inc",
                serial_number: "CC-AC-2023-002",
                status: "maintenance",
                installed_at: "2023-03-20",
                last_maintenance: "2024-01-05",
                next_maintenance: "2024-03-05",
                sensors: [
                    { value_category_id: 1, name: "Temperature", current_value: 68, unit: "°F", warning_min: 65, warning_max: 75, critical_min: 60, critical_max: 80 },
                    { value_category_id: 3, name: "Humidity", current_value: 45, unit: "%", warning_min: 30, warning_max: 60, critical_min: 20, critical_max: 70 },
                    { value_category_id: 5, name: "Air Flow", current_value: 850, unit: "CFM", warning_min: 700, warning_max: 1000, critical_min: 600, critical_max: 1200 }
                ],
                errors: 2,
                lastUpdated: new Date().toISOString()
            },
            {
                machine_id: "SEC-003",
                machine_name: "Security Camera 1",
                category_id: 3,
                category: "Security Systems",
                location: "Main Entrance",
                model: "SC-HD-Pro",
                manufacturer: "SecureTech",
                serial_number: "ST-SC-2023-003",
                status: "active",
                installed_at: "2023-02-10",
                last_maintenance: "2024-01-15",
                next_maintenance: "2024-07-15",
                sensors: [
                    { value_category_id: 7, name: "Motion Detection", current_value: 1, unit: "", warning_min: 0, warning_max: 1, critical_min: 0, critical_max: 1 },
                    { value_category_id: 6, name: "Light Level", current_value: 850, unit: "lux", warning_min: 100, warning_max: 2000, critical_min: 50, critical_max: 3000 }
                ],
                errors: 0,
                lastUpdated: new Date().toISOString()
            },
            {
                machine_id: "ENR-004",
                machine_name: "Power Distribution Unit",
                category_id: 4,
                category: "Energy Management",
                location: "Electrical Room A",
                model: "PDU-Industrial",
                manufacturer: "PowerSystems Corp",
                serial_number: "PS-PDU-2023-004",
                status: "active",
                installed_at: "2023-01-05",
                last_maintenance: "2024-01-20",
                next_maintenance: "2024-04-20",
                sensors: [
                    { value_category_id: 8, name: "Power Consumption", current_value: 125.5, unit: "kW", warning_min: 0, warning_max: 150, critical_min: 0, critical_max: 180 },
                    { value_category_id: 1, name: "Temperature", current_value: 65, unit: "°F", warning_min: 60, warning_max: 80, critical_min: 55, critical_max: 85 }
                ],
                errors: 0,
                lastUpdated: new Date().toISOString()
            }
        ];
            machineCategories.forEach(cat => {
                groupedMachines[cat.id] = { ...cat, machines: [] };
            });
            Machines.forEach(machine => {
                if (groupedMachines[machine.category_id]) {
                    groupedMachines[machine.category_id].machines.push(machine);
                }
            });

            const groups = Object.values(groupedMachines).filter(g => g.machines.length > 0);

            const html = groups.map(group => `
                <section class="category-section">
                    <div class="category-header">
                        <div class="category-icon" style="background-color: ${group.color}20">
                            <h3>${group.icon}</h3>
                        </div>
                        <h3>${group.category_name} (${group.machines.length})</h3>
                    </div>
                    <div class="machine-grid">
                        ${group.machines.map(machine => {
                            const connectionStatus = getConnectionStatus(machine);
							const categoryInfo = machineCategories.find(cat => cat.id === machine.category_id);
                            
                            return `
                                <div class="machine-card">
                                    <div class="machine-card-header">
                                        <h4>${machine.machine_name}</h4>
                                        <div class="connection-status-dot ${connectionStatus}" title="${connectionStatus}"></div>
                                    </div>
                                    <p style="font-size: 0.8rem; color: var(--color-text-secondary); margin-bottom: 1rem">${machine.machine_id}</p>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div class="status-badge ${machine.status}">${machine.status}</div>
                                        <div class="machine-info">
                                            
                                            <p><strong>Machine ID:</strong> ${machine.machine_id}</p>
											<p><strong>Category:</strong> ${categoryInfo?.category_name || machine.category}</p>
											<p><strong>Location:</strong> ${machine.location}</p>
											<p><strong>Model:</strong> ${machine.model}</p>
											<p><strong>Manufacturer:</strong> ${machine.manufacturer}</p>
											<p><strong>Sensors:</strong> ${machine.sensors.length}</p>
											<p><strong>Errors:</strong> ${machine.errors}</p>
											<p><strong>Serial Number:</strong> ${machine.serial_number}</p>
											<p><strong>Installed:</strong> ${new Date(machine.installed_at).toLocaleDateString()}</p>
                                            <p><strong>Next Maintenance:</strong> ${new Date(machine.next_maintenance).toLocaleDateString()}</p>
                            
                                        </div>
                                    </div>
                                    <div class="machine-actions">
										<button class="btn btn-primary" onclick="showStatusModal(\'${machine.machine_id}\')">ℹ️ Status</button>
										<button class="btn btn-primary" onclick="showAIDiagnosis(\'${machine.machine_id}\')">🤖 AI Diagnosis</button>
										<button class="btn btn-primary" onclick="goToLiveMonitor(\'${machine.machine_id}\')">📊 Live Monitor</button>
									</div>
                                </div>
                            `;
                        }).join("")}
                    </div>
                </section>
            `).join("");
            document.getElementById("content").innerHTML = html;
        }'."
		window.sendCommand = function(command, value) {
            /*Send rest request to send command */
        };
		function showStatusModal(){
			let status = 'teddddddd';
			
			/*Machines.forEach(machine => {
              + ' errors '  ; 
            });status + =  machine.errors.toString() 
			*/
			document.getElementById('status-content').innerHTML = `<pre style=".'"white-space: pre-wrap; font-family: inherit; line-height: 1.4; font-size: 0.95em;"'.">\${status}</pre>`;
            document.getElementById('status-modal').style.display = 'block';
		}
		function AddToggleEvent(){
		document.getElementById('theme-toggle').addEventListener('change', (e) => {
                state.theme = e.target.checked ? 'dark' : 'light';
                document.body.setAttribute('data-theme', state.theme);
		});}
		function getConnectionStatus(machine) {
            if (!machine.lastHeartbeat) return 'offline';
            if (Date.now() - machine.lastHeartbeat > HEARTBEAT_TIMEOUT) {
                return 'offline';
            }
            return 'online';
        }
		function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
		function showMachineDetails(machineId) {
            //const machine = Machines.find(m => m.machine_id === machineId);
           // if (!machine) return;

            //const categoryInfo = machineCategories.find(cat => cat.id === machine.category_id);
		}
	    function updateCurrentTime() {
            const now = new Date();
            document.getElementById('current-time').textContent = now.toLocaleTimeString();
        }");
$HtmlBody->AddElement($Script);
$Div = new Div();
$Div->AddAttrib("class","app-container");
$MenuSideBar = new Aside();
$MenuSideBar->AddAttrib("class","sidebar");
$MenuSideBar->AddAttrib("id","sidebar");

$Div1 = new Div();
$Div1->AddAttrib("class","sidebar-header");
$Span =new Span($DashboardIcon);
/*Dashboard Icon*/
$Span->AddAttrib("class","icon");
$Div1->AddElement($Span);
$DashHeader = new H1($DashboardName);
$Div1->AddElement($DashHeader);

/*Side Menu*/
$MenuSideBar->AddElement($Div1);
$MenuSideBar->AddElement(RenderMenu());
$Div->AddElement($MenuSideBar);

$MainContent = new Div();
$MainContent->AddAttrib("class","main-content");
$MainContent->AddElement(RenderHeader());
$ContentDiv =  new Div();
$ContentDiv->AddAttrib("class","content");
$ContentDiv->AddAttrib("id","content");

/*$CategorySection = New Section();
$CategorySection->AddAttrib("class","category-section");
$CategoryDiv = New Div();
$CategoryDiv->AddAttrib("class","category-header");
$CategoryIconDiv = new Div();
$CategoryIconDiv->AddAttrib("class","category-icon");
$CategoryIconDiv->AddAttrib("style","background-color: #f59e0b20");
$CategoryDiv->AddElement($CategoryIconDiv);
$CategorySection->AddElement($CategoryDiv);
$ContentDiv->AddElement($CategorySection);*/
$MainContent->AddElement($ContentDiv);
$ModalDiv = new Div();
$ModalDiv->AddAttrib("id","status-modal");
$ModalDiv->AddAttrib("style","display: none;");
$ModalDiv->AddAttrib("class","modal");

$StatusModal = new Div();
$StatusModal->AddAttrib("class","modal-content");

$Span = new Span ("x");
$Span->AddAttrib("class","close");
$Span->AddAttrib("onclick","closeModal('status-modal')");
$StatusModal->AddElement($Span);
$H3 = new H3("Machine Status");
$ContentBody = new Div();
$ContentBody->AddElement($H3);
$ContentBody->AddAttrib("id","status-content");
$StatusModal->AddElement($ContentBody);
$ModalDiv->AddElement($StatusModal);

/*<div class="content" id="content">
                <section class="category-section">
                    <div class="category-header">
                        <div class="category-icon" style="background-color: #f59e0b20">
                            <svg viewBox="0 0 24 24" fill="#f59e0b"><path d="M12 3.5c-1.2 0-2.3.4-3.2 1.1L12 8l3.2-3.4c-.9-.7-2-1.1-3.2-1.1z M12 20.5c1.2 0 2.3-.4 3.2-1.1L12 16l-3.2 3.4c.9.7 2 1.1 3.2 1.1z M5.1 6.3C4.4 7.2 4 8.3 4 9.5s.4 2.3 1.1 3.2l3.4-3.2L5.1 6.3zm13.8 0l-3.4 3.2 3.4 3.2c.7-.9 1.1-2 1.1-3.2s-.4-2.3-1.1-3.2z M12 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"></path></svg>
                        </div>
                        <h3>Solar Water Heaters (1)</h3>
                    </div>
                    <div class="machine-grid">
                        
                                <div class="machine-card">
                                    <div class="machine-card-header">
                                        <h4>Main Heater Unit</h4>
                                        <div class="connection-status-dot online" title="online"></div>
                                    </div>
                                    <p style="font-size: 0.8rem; color: var(--color-text-secondary); margin-bottom: 1rem">SWH001</p>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div class="status-badge normal">normal</div>
                                        <div class="machine-icon-container">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 3.5c-1.2 0-2.3.4-3.2 1.1L12 8l3.2-3.4c-.9-.7-2-1.1-3.2-1.1z M12 20.5c1.2 0 2.3-.4 3.2-1.1L12 16l-3.2 3.4c.9.7 2 1.1 3.2 1.1z M5.1 6.3C4.4 7.2 4 8.3 4 9.5s.4 2.3 1.1 3.2l3.4-3.2L5.1 6.3zm13.8 0l-3.4 3.2 3.4 3.2c.7-.9 1.1-2 1.1-3.2s-.4-2.3-1.1-3.2z M12 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"></path>
                                            </svg>
                                            <span>Solar Water Heaters</span>
                                        </div>
                                    </div>
                                    <div class="card-actions">
                                        <button class="btn btn-primary" onclick="monitorMachine('SWH001')">Monitor Details</button>
                                    </div>
                                </div>
                            
                    </div>
                </section>
            </div> */
	$Div->AddElement($ModalDiv);		
$Div->AddElement($MainContent);

$HtmlBody->AddElement($Div);
$HtmlDoc->AddElement($HtmlBody);
$HtmlDoc->render();

function RenderHeader(){
	global $State;
	global $CompanyName;
	global $UserName;
	$Header = new Header();
	$Header->AddAttrib("class","header");
	$Header->AddAttrib("id","header");
	$H2 = new H2($State["view"]);
	$Header->AddElement($H2);
	$UserDiv =  new Div();
	$UserDiv->AddAttrib("class","user-info");
	$Span = new Span($CompanyName);
	$Span->AddAttrib("id","company-name");
	$UserDiv->AddElement($Span);
	$Span = new Span($UserName);
	$Span->AddAttrib("id","current-user");
	$UserDiv->AddElement($Span);
	$Span = new Span();
	$Span->AddAttrib("id","current-time");
	$Script = new Script("updateCurrentTime();
	// Update every second
    setInterval(updateCurrentTime, 1000);");
	$Span->AddElement($Script);
	$UserDiv->AddElement($Span);
	$Header->AddElement($UserDiv);
	$ToggleDiv = new Div();
	$ToggleDiv->AddAttrib("class","toggle-switch-container");
	$Span = new Span("Light");
	$ToggleDiv->AddElement($Span);
	$Label= new Label();
	$Label->AddAttrib("class","toggle-switch");
	$Input = new Input();
	$Input->AddAttrib("type","checkbox");
    if ($State["theme"] == "dark"){  
		$Input->AddAttrib("","checked");
	}
	$Input->AddAttrib("id","theme-toggle");
			
	$Label->AddElement($Input);
	$Span = new Span();
	$Span->AddAttrib("class","slider");
	$Label->AddElement($Span);
	$ToggleDiv->AddElement($Label);
	$Span = new Span("Dark");
	$ToggleDiv->AddElement($Span);
	$Header->AddElement($ToggleDiv);
	return $Header;
}

function RenderMenu() {
	  global $State;
	  
	  $MenuList =  new UL();
	  $navItems = ['Dashboard', 'Live Monitoring', 'Error Reports', 'Device Management', 'Settings','Profile'];
      $navIcons = [
                "Dashboard" => "M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z",
                "Live Monitoring"=> "M16 18h2V6h-2v12zm-4 4h2V2h-2v20zm-4 0h2V12H8v10zm8 0h2V10h-2v12z",
                "Error Reports"=> "M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z",
                "Device Management"=> "M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z",
                "Settings"=> "M19.43 12.98c.04-.32.07-.64.07-.98s-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.23.09.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"
              , "Profile" => "M4 20c0-4 4-6 8-6s8 2 8 6" /*307 329.736 203.689C323.195 186.27 317.084 171.098 301.61 159.388C298.943 157.37 295.72 154.455 292.391 153.695ZM341.683 201.843C339.7 206.366 336.69 218.858 335.851 223.93C336.719 223.554 337.603 223.198 338.456 222.791C344.356 218.946 349.268 205.308 341.683 201.843ZM170.602 201.843C163.046 208.015 167.477 218.292 173.434 223.93L176.032 224.855C175.698 222.664 171.343 202.5 171.009 201.97L170.602 201.843ZM222.293 288.877C221.897 293.668 221.231 298.662 221.215 303.463C237.749 326.923 263.351 334.584 284.212 311.204C291.986 302.106 289.68 300.598 289.943 288.877C271.647 297.623 254.114 300.951 234.164 293.91C230.115 292.481 226.366 290.131 222.293 288.877ZM299.087 308.843C288.753 324.403 280.247 330.979 262.04 335.477C266.213 342.755 271.375 349.765 276.166 356.665C277.275 356.11 278.41 355.582 279.492 354.976C298.178 344.616 310.06 332.693 317.378 312.03C311.725 310.268 305.007 309.005 299.087 308.843ZM210.25 308.843C204.576 309.686 199.079 310.708 193.497 312.03C199.776 327.746 209.705 339.634 223.629 349.088C226.826 351.259 230.466 352.731 233.595 354.976C234.383 355.19 235.19 355.482 236.013 355.468C240.456 348.786 245.284 342.316 249.486 335.477C234.953 331.795 224.339 325.673 215.086 313.682C213.872 312.108 212.603 308.338 210.25 308.843ZM327.626 314.945C322.231 334.46 306.159 351.575 288.955 361.313C285.28 363.393 276.042 369.101 272.014 367.843C269.13 366.943 258.653 348.801 255.917 345.237L246.889 358.678C245.27 361.06 242.16 367.211 239.02 367.818C234.374 368.716 218.069 358.474 213.689 355.203C198.823 344.103 190.631 332.679 183.39 315.726C168.296 320.476 151.891 330.709 141.403 342.62C129.848 355.743 101.497 403.522 127.052 416.327C132.275 418.944 149.294 417.941 155.868 417.95L166.733 417.95L166.687 405.997C166.667 402.789 165.918 398.289 168.469 395.776C171.811 392.485 176.636 395.241 177.444 399.24C178.292 403.435 177.456 413.081 177.611 417.95L282.069 417.95C299.447 417.95 316.87 418.231 334.243 417.95C334.228 413.353 333.68 403.291 334.54 399.306C335.448 395.103 340.258 392.58 343.435 396.525C346.111 399.847 345.141 413.262 345.119 417.95L365.258 417.964C370.684 417.965 377.126 418.617 382.397 417.184C398.471 412.814 395.093 395.42 392.165 383.669C384.227 351.803 360.053 323.868 327.886 315.015L327.626 314.945Z" /*"M163.557 193.389C163.746 186.221 163.413 179.051 163.699 171.88C165.68 122.168 191.222 87.6544 241.46 82.7422C265.065 81.6317 290.761 87.5681 310.068 101.64C319.241 108.326 317.504 105.514 326.489 109.472C358.009 123.355 355.316 165.147 343.55 192.138C361.342 196.453 361.841 230.932 331.902 235.469C325.62 253.216 315.174 268.956 300.446 280.77L300.446 298.207C307.386 298.345 314.456 299.871 321.142 301.682C363.872 313.253 394.74 342.254 403.481 386.333C406.978 403.964 405.112 423.573 383.257 427.93C378.034 428.971 372.46 428.677 367.153 428.679L277.134 428.675L146.545 428.686C141.071 428.685 135.037 429.116 129.634 428.249C117.048 426.23 107.115 414.685 105.887 402.22C104.617 389.332 113.625 366.543 119.778 355.123C138.037 321.235 173.515 301.943 211.283 298.207C211.479 292.673 212.161 287.149 212.234 281.619C196.1 267.297 187.699 256.538 179.763 235.469C157.642 234.926 147.989 206.767 163.557 193.389ZM242.738 93.2837C185.507 98.19 173.547 142.175 173.938 192.138C187.237 173.669 193.779 164.515 219.453 160.397C239.784 157.136 256.377 163.891 277.134 151.742C288.35 145.184 286.905 138.177 300.014 145.874C315.769 155.124 328.212 170.254 334.243 187.529C344.875 166.689 346.546 123.647 317.245 117.587C305.121 115.08 309.256 112.914 300.02 107.343C282.836 96.9787 262.645 92.9674 242.738 93.2837ZM292.391 153.695C257.806 184.047 216.772 156.187 190.583 186.821C186.636 191.437 184.561 196.609 181.704 201.843C188.187 232.649 197.862 262.194 227.313 279.023C263.304 298.072 297.581 280.247 315.59 246.119C321.914 234.135 327.502 217.307 329.736 203.689C323.195 186.27 317.084 171.098 301.61 159.388C298.943 157.37 295.72 154.455 292.391 153.695ZM341.683 201.843C339.7 206.366 336.69 218.858 335.851 223.93C336.719 223.554 337.603 223.198 338.456 222.791C344.356 218.946 349.268 205.308 341.683 201.843ZM170.602 201.843C163.046 208.015 167.477 218.292 173.434 223.93L176.032 224.855C175.698 222.664 171.343 202.5 171.009 201.97L170.602 201.843ZM222.293 288.877C221.897 293.668 221.231 298.662 221.215 303.463C237.749 326.923 263.351 334.584 284.212 311.204C291.986 302.106 289.68 300.598 289.943 288.877C271.647 297.623 254.114 300.951 234.164 293.91C230.115 292.481 226.366 290.131 222.293 288.877ZM299.087 308.843C288.753 324.403 280.247 330.979 262.04 335.477C266.213 342.755 271.375 349.765 276.166 356.665C277.275 356.11 278.41 355.582 279.492 354.976C298.178 344.616 310.06 332.693 317.378 312.03C311.725 310.268 305.007 309.005 299.087 308.843ZM210.25 308.843C204.576 309.686 199.079 310.708 193.497 312.03C199.776 327.746 209.705 339.634 223.629 349.088C226.826 351.259 230.466 352.731 233.595 354.976C234.383 355.19 235.19 355.482 236.013 355.468C240.456 348.786 245.284 342.316 249.486 335.477C234.953 331.795 224.339 325.673 215.086 313.682C213.872 312.108 212.603 308.338 210.25 308.843ZM327.626 314.945C322.231 334.46 306.159 351.575 288.955 361.313C285.28 363.393 276.042 369.101 272.014 367.843C269.13 366.943 258.653 348.801 255.917 345.237L246.889 358.678C245.27 361.06 242.16 367.211 239.02 367.818C234.374 368.716 218.069 358.474 213.689 355.203C198.823 344.103 190.631 332.679 183.39 315.726C168.296 320.476 151.891 330.709 141.403 342.62C129.848 355.743 101.497 403.522 127.052 416.327C132.275 418.944 149.294 417.941 155.868 417.95L166.733 417.95L166.687 405.997C166.667 402.789 165.918 398.289 168.469 395.776C171.811 392.485 176.636 395.241 177.444 399.24C178.292 403.435 177.456 413.081 177.611 417.95L282.069 417.95C299.447 417.95 316.87 418.231 334.243 417.95C334.228 413.353 333.68 403.291 334.54 399.306C335.448 395.103 340.258 392.58 343.435 396.525C346.111 399.847 345.141 413.262 345.119 417.95L365.258 417.964C370.684 417.965 377.126 418.617 382.397 417.184C398.471 412.814 395.093 395.42 392.165 383.669C384.227 351.803 360.053 323.868 327.886 315.015L327.626 314.945Z"*/];
    $MenuList = new UL();// Code to execute
	$MenuList->AddAttrib("style","list-style-type: none;");
	$listArray = explode(",", $GLOBALS["UserMenu"]);
	foreach($navItems as $MenuIcon){
	// Convert the string into an array
	
	// Check if the item exists in the array
	if (in_array($MenuIcon, $listArray)) {
		$listitem =  new LI();
		$listitem->AddAttrib("class","nav-item");
		$A =  new A();
		$A->AddAttrib("href","#"); 
		if ($State["view"] == $MenuIcon) 
		{	$class = "active";}
	else {$class = "";}	
		//$class = "\${state.view === ". $MenuIcon . "? 'active' : ''}";
		$A->AddAttrib("class",$class);
		$A->AddAttrib("data-view",$MenuIcon);
		$SVG =  new SVG();
		$SVG->AddAttrib("class","nav-icon");
		$SVG->AddAttrib("viewBox","0 0 24 24");
		$Path = New Path();
		$Path->AddAttrib("d",$navIcons[$MenuIcon]);
		if ($MenuIcon=="Profile"){
			$Circle =new Circle();
			$Circle->AddAttrib("xmlns","http://www.w3.org/2000/svg");
			$Circle->AddAttrib("cx","12");
			$Circle->AddAttrib("cy","8");
			$Circle->AddAttrib("r","4");
			$SVG->AddElement($Circle);
		}
		
		$SVG->AddElement($Path);
		$A->AddElement($SVG);
		$Span = new  Span($MenuIcon);
		$A->AddElement($Span);
		$listitem->AddElement($A);
		$MenuList->AddElement($listitem);
	}
	}
    return $MenuList; // Optional
}

?>
