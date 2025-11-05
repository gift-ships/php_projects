import React, { useState, useEffect } from 'react';
import { Activity, AlertTriangle, Settings, Users, Monitor, BarChart3, Zap, TrendingUp, Bell, Search, Plus, Edit, Trash2, Save, X, Eye, Brain, Home } from 'lucide-react';

// Mock data based on the database schema
const mockMachineCategories = [
  { id: 1, name: 'Industrial Dryers', code: 'DRYER', color: '#FF6B6B', icon: '🌡️' },
  { id: 2, name: 'HVAC Systems', code: 'HVAC', color: '#4ECDC4', icon: '❄️' },
  { id: 3, name: 'Pumps', code: 'PUMP', color: '#45B7D1', icon: '💧' },
  { id: 4, name: 'Compressors', code: 'COMPRESSOR', color: '#96CEB4', icon: '🔧' },
  { id: 5, name: 'Conveyors', code: 'CONVEYOR', color: '#FFEAA7', icon: '📦' }
];

const mockMachines = [
  { id: 'MACH001', name: 'Dryer Unit 1', categoryId: 1, location: 'Building A - Floor 2', status: 'active', model: 'DX-100', lastMaintenance: '2024-09-15' },
  { id: 'MACH002', name: 'Dryer Unit 2', categoryId: 1, location: 'Building A - Floor 2', status: 'active', model: 'DX-100', lastMaintenance: '2024-09-20' },
  { id: 'MACH003', name: 'Dryer Unit 3', categoryId: 1, location: 'Building B - Floor 1', status: 'error', model: 'DX-200', lastMaintenance: '2024-08-10' },
  { id: 'MACH004', name: 'HVAC Main Unit', categoryId: 2, location: 'Building A - Roof', status: 'active', model: 'HV-500', lastMaintenance: '2024-07-05' },
  { id: 'MACH005', name: 'Water Pump 1', categoryId: 3, location: 'Building C - Basement', status: 'active', model: 'WP-350', lastMaintenance: '2024-09-12' },
  { id: 'MACH006', name: 'Air Compressor 1', categoryId: 4, location: 'Building B - Floor 1', status: 'maintenance', model: 'AC-750', lastMaintenance: '2024-10-01' },
  { id: 'MACH007', name: 'Conveyor Belt A', categoryId: 5, location: 'Building D - Warehouse', status: 'active', model: 'CB-1000', lastMaintenance: '2024-10-15' }
];

const mockSensors = [
  { id: 1, name: 'External Temperature', code: 'external_temp', unit: '°C', type: 'integer' },
  { id: 2, name: 'Reservoir Temperature', code: 'reservoir_temp', unit: '°C', type: 'integer' },
  { id: 3, name: 'Drum Temperature', code: 'drum_temp', unit: '°C', type: 'integer' },
  { id: 4, name: 'Fan State', code: 'fan_state', unit: 'on/off', type: 'boolean' },
  { id: 5, name: 'Motor State', code: 'motor_state', unit: 'on/off', type: 'boolean' },
  { id: 6, name: 'Motor Speed', code: 'motor_speed', unit: 'RPM', type: 'integer' },
  { id: 7, name: 'Pressure', code: 'pressure', unit: 'PSI', type: 'decimal' },
  { id: 8, name: 'Humidity', code: 'humidity', unit: '%', type: 'integer' },
  { id: 9, name: 'Vibration Level', code: 'vibration', unit: 'mm/s', type: 'decimal' },
  { id: 10, name: 'Power Consumption', code: 'power_consumption', unit: 'kW', type: 'decimal' },
  { id: 11, name: 'Flow Rate', code: 'flow_rate', unit: 'L/min', type: 'decimal' }
];

const mockErrors = [
  { id: 1, machineId: 'MACH003', errorCode: 'ERR_OVERHEAT', errorName: 'Overheating', severity: 'critical', timestamp: '2024-10-04 09:15:00', status: 'open', details: 'Drum temperature exceeded 175°C' },
  { id: 2, machineId: 'MACH002', errorCode: 'ERR_HIGH_VIBRATION', errorName: 'Excessive Vibration', severity: 'error', timestamp: '2024-10-04 08:20:00', status: 'acknowledged', details: 'Bearings may need inspection' },
  { id: 3, machineId: 'MACH006', errorCode: 'ERR_MOTOR_FAIL', errorName: 'Motor Failure', severity: 'critical', timestamp: '2024-10-02 16:45:00', status: 'in_progress', details: 'Motor failed to start after maintenance' }
];

const mockUsers = [
  { id: 1, name: 'John Smith', email: 'john.smith@company.com', role: 'admin', status: 'Active', lastLogin: '2024-10-23 08:30:00' },
  { id: 2, name: 'Sarah Johnson', email: 'sarah.j@company.com', role: 'operator', status: 'Active', lastLogin: '2024-10-23 07:15:00' },
  { id: 3, name: 'Mike Wilson', email: 'mike.w@company.com', role: 'technician', status: 'Active', lastLogin: '2024-10-22 16:45:00' },
  { id: 4, name: 'Emily Davis', email: 'emily.d@company.com', role: 'operator', status: 'Inactive', lastLogin: '2024-10-15 14:20:00' }
];

const mockErrorTypes = [
  { id: 1, code: 'ERR_OVERHEAT', name: 'Overheating', severity: 'critical', description: 'Temperature exceeded safe operating limits' },
  { id: 2, code: 'ERR_MOTOR_FAIL', name: 'Motor Failure', severity: 'critical', description: 'Motor failed to start or stopped unexpectedly' },
  { id: 3, code: 'ERR_HIGH_VIBRATION', name: 'Excessive Vibration', severity: 'error', description: 'Vibration levels exceed safe threshold' },
  { id: 4, code: 'ERR_LOW_PRESSURE', name: 'Low Pressure', severity: 'warning', description: 'System pressure below operational minimum' }
];

const generateSensorData = (sensorType, hours = 24) => {
  const data = [];
  const now = new Date();
  for (let i = hours; i >= 0; i--) {
    const time = new Date(now - i * 3600000);
    let value;
    switch (sensorType) {
      case 'external_temp':
        value = 20 + Math.random() * 10;
        break;
      case 'drum_temp':
        value = 60 + Math.random() * 40;
        break;
      case 'motor_speed':
        value = 1100 + Math.random() * 300;
        break;
      case 'pressure':
        value = 120 + Math.random() * 30;
        break;
      case 'humidity':
        value = 30 + Math.random() * 30;
        break;
      default:
        value = Math.random() * 100;
    }
    data.push({
      time: time.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }),
      value: Math.round(value * 10) / 10
    });
  }
  return data;
};

const App = () => {
  const [activeTab, setActiveTab] = useState('dashboard');
  const [currentUser, setCurrentUser] = useState(mockUsers[0]);
  const [selectedMachine, setSelectedMachine] = useState(null);
  const [selectedSensor, setSelectedSensor] = useState(null);
  const [users, setUsers] = useState(mockUsers);
  const [editingUser, setEditingUser] = useState(null);
  const [searchQuery, setSearchQuery] = useState('');
  const [showAIDiagnosis, setShowAIDiagnosis] = useState(false);
  const [errorTypes, setErrorTypes] = useState(mockErrorTypes);
  const [editingError, setEditingError] = useState(null);
  const [machines, setMachines] = useState(mockMachines);
  const [editingMachine, setEditingMachine] = useState(null);

  const StatusBadge = ({ status }) => {
    const colors = {
      active: 'bg-green-100 text-green-800',
      error: 'bg-red-100 text-red-800',
      maintenance: 'bg-yellow-100 text-yellow-800',
      inactive: 'bg-gray-100 text-gray-800'
    };
    return (
      <span className={`px-3 py-1 rounded-full text-xs font-semibold ${colors[status] || colors.inactive}`}>
        {status.toUpperCase()}
      </span>
    );
  };

  const SeverityBadge = ({ severity }) => {
    const colors = {
      critical: 'bg-red-100 text-red-800 border-red-300',
      error: 'bg-orange-100 text-orange-800 border-orange-300',
      warning: 'bg-yellow-100 text-yellow-800 border-yellow-300',
      info: 'bg-blue-100 text-blue-800 border-blue-300'
    };
    return (
      <span className={`px-2 py-1 rounded border text-xs font-semibold ${colors[severity] || colors.info}`}>
        {severity.toUpperCase()}
      </span>
    );
  };

  const DashboardTab = () => {
    const machinesByCategory = mockMachineCategories.map(category => ({
      ...category,
      machines: machines.filter(m => m.categoryId === category.id)
    }));

    return (
      <div className="p-6">
        <div className="mb-6">
          <h1 className="text-3xl font-bold text-gray-800 mb-2">Machine Dashboard</h1>
          <p className="text-gray-600">Monitor all machines across your facilities</p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
          <div className="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-gray-600 text-sm">Active Machines</p>
                <p className="text-3xl font-bold text-gray-800">{machines.filter(m => m.status === 'active').length}</p>
              </div>
              <Activity className="text-green-500" size={40} />
            </div>
          </div>
          <div className="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-gray-600 text-sm">Critical Errors</p>
                <p className="text-3xl font-bold text-gray-800">{mockErrors.filter(e => e.severity === 'critical').length}</p>
              </div>
              <AlertTriangle className="text-red-500" size={40} />
            </div>
          </div>
          <div className="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-gray-600 text-sm">Maintenance</p>
                <p className="text-3xl font-bold text-gray-800">{machines.filter(m => m.status === 'maintenance').length}</p>
              </div>
              <Settings className="text-yellow-500" size={40} />
            </div>
          </div>
          <div className="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-gray-600 text-sm">Total Machines</p>
                <p className="text-3xl font-bold text-gray-800">{machines.length}</p>
              </div>
              <Monitor className="text-blue-500" size={40} />
            </div>
          </div>
        </div>

        {machinesByCategory.map(category => (
          category.machines.length > 0 && (
            <div key={category.id} className="mb-8">
              <div className="flex items-center mb-4">
                <span className="text-2xl mr-3">{category.icon}</span>
                <h2 className="text-2xl font-bold text-gray-800">{category.name}</h2>
                <span className="ml-3 px-3 py-1 rounded-full text-sm font-semibold" style={{ backgroundColor: category.color + '20', color: category.color }}>
                  {category.machines.length} machines
                </span>
              </div>
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                {category.machines.map(machine => (
                  <div key={machine.id} className="bg-white rounded-lg shadow hover:shadow-lg transition-shadow p-6 border-t-4" style={{ borderColor: category.color }}>
                    <div className="flex justify-between items-start mb-4">
                      <div>
                        <h3 className="text-lg font-bold text-gray-800">{machine.name}</h3>
                        <p className="text-sm text-gray-600">{machine.id}</p>
                      </div>
                      <StatusBadge status={machine.status} />
                    </div>
                    <div className="space-y-2 mb-4">
                      <p className="text-sm text-gray-600"><span className="font-semibold">Location:</span> {machine.location}</p>
                      <p className="text-sm text-gray-600"><span className="font-semibold">Model:</span> {machine.model}</p>
                      <p className="text-sm text-gray-600"><span className="font-semibold">Last Maintenance:</span> {machine.lastMaintenance}</p>
                    </div>
                    {mockErrors.filter(e => e.machineId === machine.id).length > 0 && (
                      <div className="mb-4 p-3 bg-red-50 rounded border border-red-200">
                        <p className="text-sm font-semibold text-red-800">
                          <AlertTriangle size={16} className="inline mr-1" />
                          {mockErrors.filter(e => e.machineId === machine.id).length} Active Error(s)
                        </p>
                      </div>
                    )}
                    <div className="flex gap-2">
                      <button
                        onClick={() => {
                          setSelectedMachine(machine);
                          setShowAIDiagnosis(false);
                        }}
                        className="flex-1 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors text-sm font-semibold flex items-center justify-center"
                      >
                        <Eye size={16} className="mr-1" /> View Details
                      </button>
                      <button
                        onClick={() => {
                          setSelectedMachine(machine);
                          setActiveTab('monitor');
                        }}
                        className="flex-1 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors text-sm font-semibold flex items-center justify-center"
                      >
                        <Monitor size={16} className="mr-1" /> Live Monitor
                      </button>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          )
        ))}
      </div>
    );
  };

  const MachineDetailsModal = () => {
    if (!selectedMachine) return null;

    const machineErrors = mockErrors.filter(e => e.machineId === selectedMachine.id);
    const category = mockMachineCategories.find(c => c.id === selectedMachine.categoryId);

    const getAIDiagnosis = () => {
      const hasErrors = machineErrors.length > 0;
      if (hasErrors) {
        const criticalErrors = machineErrors.filter(e => e.severity === 'critical');
        if (criticalErrors.length > 0) {
          return {
            status: 'Critical',
            color: 'red',
            recommendation: 'Immediate shutdown recommended. Critical overheating detected in drum temperature sensor. This could lead to equipment damage or safety hazards. Recommended actions: 1) Stop machine operation immediately, 2) Inspect cooling system and heat exchangers, 3) Check thermostat calibration, 4) Verify fan operation, 5) Contact maintenance team for emergency service.',
            confidence: '95%'
          };
        }
        return {
          status: 'Attention Required',
          color: 'orange',
          recommendation: 'Excessive vibration detected. This may indicate bearing wear or mechanical imbalance. Recommended actions: 1) Schedule maintenance inspection within 24 hours, 2) Monitor vibration levels closely, 3) Check motor mounting bolts, 4) Inspect drive belts for wear.',
          confidence: '87%'
        };
      }
      return {
        status: 'Optimal',
        color: 'green',
        recommendation: 'All systems operating within normal parameters. Machine is performing efficiently. Current readings show stable temperature, appropriate motor speed, and normal vibration levels. Continue regular monitoring and maintain scheduled maintenance intervals.',
        confidence: '92%'
      };
    };

    const diagnosis = getAIDiagnosis();

    return (
      <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div className="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
          <div className="sticky top-0 bg-white border-b p-6 flex justify-between items-center">
            <div>
              <h2 className="text-2xl font-bold text-gray-800">{selectedMachine.name}</h2>
              <p className="text-gray-600">{selectedMachine.id} - {category?.name}</p>
            </div>
            <button onClick={() => setSelectedMachine(null)} className="text-gray-500 hover:text-gray-700">
              <X size={24} />
            </button>
          </div>

          <div className="p-6">
            <div className="grid grid-cols-2 gap-4 mb-6">
              <div className="bg-gray-50 p-4 rounded">
                <p className="text-sm text-gray-600">Status</p>
                <div className="mt-2"><StatusBadge status={selectedMachine.status} /></div>
              </div>
              <div className="bg-gray-50 p-4 rounded">
                <p className="text-sm text-gray-600">Location</p>
                <p className="font-semibold text-gray-800 mt-1">{selectedMachine.location}</p>
              </div>
              <div className="bg-gray-50 p-4 rounded">
                <p className="text-sm text-gray-600">Model</p>
                <p className="font-semibold text-gray-800 mt-1">{selectedMachine.model}</p>
              </div>
              <div className="bg-gray-50 p-4 rounded">
                <p className="text-sm text-gray-600">Last Maintenance</p>
                <p className="font-semibold text-gray-800 mt-1">{selectedMachine.lastMaintenance}</p>
              </div>
            </div>

            {machineErrors.length > 0 && (
              <div className="mb-6">
                <h3 className="text-lg font-bold text-gray-800 mb-3">Active Errors</h3>
                <div className="space-y-3">
                  {machineErrors.map(error => (
                    <div key={error.id} className="bg-red-50 border border-red-200 rounded p-4">
                      <div className="flex justify-between items-start mb-2">
                        <div>
                          <p className="font-bold text-red-900">{error.errorName}</p>
                          <p className="text-sm text-red-700">{error.errorCode}</p>
                        </div>
                        <SeverityBadge severity={error.severity} />
                      </div>
                      <p className="text-sm text-gray-700 mb-2">{error.details}</p>
                      <p className="text-xs text-gray-600">Detected: {error.timestamp}</p>
                      <div className="mt-2">
                        <span className="px-2 py-1 bg-white rounded text-xs font-semibold text-gray-700 border border-gray-300">
                          Status: {error.status.replace('_', ' ').toUpperCase()}
                        </span>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}

            <div className="mb-6">
              <button
                onClick={() => setShowAIDiagnosis(!showAIDiagnosis)}
                className="w-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-lg hover:from-purple-600 hover:to-indigo-700 transition-all font-semibold flex items-center justify-center"
              >
                <Brain size={20} className="mr-2" />
                {showAIDiagnosis ? 'Hide' : 'Show'} AI Diagnosis & Recommendations
              </button>
            </div>

            {showAIDiagnosis && (
              <div className="border-2 rounded-lg p-6 mb-6 bg-gradient-to-r from-purple-50 to-indigo-50 border-purple-300">
                <div className="flex items-start justify-between mb-4">
                  <div className="flex items-center">
                    <Brain size={32} className="text-purple-600 mr-3" />
                    <div>
                      <h3 className="text-xl font-bold text-gray-800">AI Analysis</h3>
                      <p className="text-sm text-gray-600">Confidence: {diagnosis.confidence}</p>
                    </div>
                  </div>
                  <span className="px-4 py-2 rounded-full font-bold text-gray-800 bg-white shadow">
                    {diagnosis.status}
                  </span>
                </div>
                <div className="bg-white rounded p-4 border border-gray-200">
                  <p className="text-gray-800 leading-relaxed">{diagnosis.recommendation}</p>
                </div>
              </div>
            )}

            <div className="flex gap-4">
              <button
                onClick={() => {
                  setActiveTab('monitor');
                }}
                className="flex-1 bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors font-semibold flex items-center justify-center"
              >
                <Monitor size={20} className="mr-2" />
                Go to Live Monitor
              </button>
              <button
                onClick={() => setSelectedMachine(null)}
                className="flex-1 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors font-semibold"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    );
  };

  const MonitorTab = () => {
    const [monitorMachine, setMonitorMachine] = useState(selectedMachine);
    const [activeSensor, setActiveSensor] = useState(null);

    const machineSensors = monitorMachine?.categoryId === 1 || monitorMachine?.categoryId === 2
      ? mockSensors.slice(0, 8)
      : monitorMachine?.categoryId === 3
      ? [mockSensors[0], mockSensors[6], mockSensors[8], mockSensors[9], mockSensors[10]]
      : mockSensors.slice(0, 6);

    const getCurrentValue = (sensor) => {
      switch (sensor.code) {
        case 'external_temp': return 22 + Math.random() * 5;
        case 'drum_temp': return 65 + Math.random() * 30;
        case 'motor_speed': return 1150 + Math.random() * 200;
        case 'pressure': return 125 + Math.random() * 20;
        case 'humidity': return 35 + Math.random() * 20;
        case 'vibration': return 5 + Math.random() * 10;
        case 'power_consumption': return 15 + Math.random() * 10;
        case 'flow_rate': return 450 + Math.random() * 100;
        default: return Math.random() * 100;
      }
    };

    const LineChart = ({ data, color, unit }) => {
      const maxValue = Math.max(...data.map(d => d.value));
      const minValue = Math.min(...data.map(d => d.value));
      const range = maxValue - minValue || 1;

      return (
        <div className="relative h-64 bg-gray-50 rounded p-4">
          <div className="flex justify-between text-xs text-gray-600 mb-2">
            <span>Max: {maxValue.toFixed(1)}{unit}</span>
            <span>Min: {minValue.toFixed(1)}{unit}</span>
          </div>
          <svg width="100%" height="200" className="overflow-visible">
            <polyline
              fill="none"
              stroke={color}
              strokeWidth="3"
              points={data.map((d, i) => {
                const x = (i / (data.length - 1)) * 100;
                const y = 100 - ((d.value - minValue) / range) * 90;
                return `${x}%,${y}%`;
              }).join(' ')}
            />
            {data.map((d, i) => {
              const x = (i / (data.length - 1)) * 100;
              const y = 100 - ((d.value - minValue) / range) * 90;
              return (
                <circle
                  key={i}
                  cx={`${x}%`}
                  cy={`${y}%`}
                  r="3"
                  fill={color}
                />
              );
            })}
          </svg>
          <div className="flex justify-between text-xs text-gray-600 mt-2">
            {data.filter((item, i) => i % 4 === 0).map((d, i) => (
              <span key={i}>{d.time}</span>
            ))}
          </div>
        </div>
      );
    };

    if (!monitorMachine) {
      return (
        <div className="p-6">
          <h1 className="text-3xl font-bold text-gray-800 mb-6">Live Monitoring</h1>
          <div className="bg-white rounded-lg shadow p-6">
            <p className="text-gray-600 mb-4">Select a machine to monitor:</p>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              {machines.map(machine => (
                <button
                  key={machine.id}
                  onClick={() => setMonitorMachine(machine)}
                  className="bg-gray-50 hover:bg-blue-50 border-2 border-gray-200 hover:border-blue-500 rounded-lg p-4 text-left transition-all"
                >
                  <h3 className="font-bold text-gray-800">{machine.name}</h3>
                  <p className="text-sm text-gray-600 mb-2">{machine.id}</p>
                  <StatusBadge status={machine.status} />
                </button>
              ))}
            </div>
          </div>
        </div>
      );
    }

    if (activeSensor) {
      const sensorData = generateSensorData(activeSensor.code);
      const currentValue = getCurrentValue(activeSensor);
      const avgValue = sensorData.reduce((sum, d) => sum + d.value, 0) / sensorData.length;
      const maxValue = Math.max(...sensorData.map(d => d.value));
      const minValue = Math.min(...sensorData.map(d => d.value));

      return (
        <div className="p-6">
          <div className="mb-6">
            <button
              onClick={() => setActiveSensor(null)}
              className="text-blue-500 hover:text-blue-700 mb-4 flex items-center font-semibold"
            >
              ← Back to Sensors
            </button>
            <div className="flex justify-between items-center">
              <div>
                <h1 className="text-3xl font-bold text-gray-800">{activeSensor.name}</h1>
                <p className="text-gray-600">{monitorMachine.name} - {monitorMachine.id}</p>
              </div>
              <div className="text-right">
                <p className="text-sm text-gray-600">Current Reading</p>
                <p className="text-4xl font-bold text-blue-600">
                  {currentValue.toFixed(1)} <span className="text-xl text-gray-600">{activeSensor.unit}</span>
                </p>
              </div>
            </div>
          </div>

          <div className="bg-white rounded-lg shadow p-6 mb-6">
            <h2 className="text-xl font-bold text-gray-800 mb-4">24-Hour Timeline</h2>
            <Line