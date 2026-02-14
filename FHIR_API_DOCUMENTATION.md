# FHIR API Documentation - Dentix Klinik Gigi

## Overview

FHIR (Fast Healthcare Interoperability Resources) API untuk sistem informasi klinik gigi Dentix.
Spec: http://hl7.org/fhir/

Base URL: `https://dentix.my.id/api/fhir`

---

## 🏥 FHIR Resources Implemented

1. **Patient** - Data pasien
2. **Appointment** - Janji temu
3. **Condition** - Diagnosis/keluhan
4. **Procedure** - Tindakan medis

---

## 📋 PATIENT Resource

### Get Single Patient

```
GET /fhir/Patient/{id}
```

**Example Request:**

```
GET https://dentix.my.id/api/fhir/Patient/1
```

**Example Response:**

```json
{
    "resourceType": "Patient",
    "id": "1",
    "identifier": [
        {
            "system": "https://dentix.my.id/patient-id",
            "value": "P-000001"
        }
    ],
    "active": true,
    "name": [
        {
            "use": "official",
            "text": "John Doe",
            "family": "Doe",
            "given": ["John"]
        }
    ],
    "telecom": [
        {
            "system": "phone",
            "value": "081234567890",
            "use": "mobile"
        },
        {
            "system": "email",
            "value": "john.doe@example.com"
        }
    ],
    "address": [
        {
            "use": "home",
            "text": "Jl. Raya No. 123, Jakarta",
            "country": "ID"
        }
    ],
    "meta": {
        "lastUpdated": "2026-02-13T07:00:00+07:00"
    }
}
```

### Get All Patients

```
GET /fhir/Patient
GET /fhir/Patient?_count=50
```

**Query Parameters:**

- `_count` - Number of results per page (default: 20)

**Example Response:**

```json
{
  "resourceType": "Bundle",
  "type": "searchset",
  "total": 150,
  "entry": [
    {
      "resource": {
        "resourceType": "Patient",
        "id": "1",
        ...
      }
    }
  ],
  "link": [
    {
      "relation": "self",
      "url": "https://dentix.my.id/api/fhir/Patient"
    },
    {
      "relation": "next",
      "url": "https://dentix.my.id/api/fhir/Patient?page=2"
    }
  ]
}
```

### Get Patient Everything

```
GET /fhir/Patient/{id}/$everything
```

**Description:** Returns all data for a patient (Patient + Appointments + Conditions + Procedures)

**Example Request:**

```
GET https://dentix.my.id/api/fhir/Patient/1/$everything
```

---

## 📅 APPOINTMENT Resource

### Get Single Appointment

```
GET /fhir/Appointment/{id}
```

**Example Response:**

```json
{
    "resourceType": "Appointment",
    "id": "1",
    "status": "booked",
    "appointmentType": {
        "coding": [
            {
                "system": "http://terminology.hl7.org/CodeSystem/v2-0276",
                "code": "ROUTINE",
                "display": "Routine appointment"
            }
        ]
    },
    "description": "Sakit gigi geraham",
    "start": "2026-02-20T10:00:00+07:00",
    "end": "2026-02-20T10:30:00+07:00",
    "participant": [
        {
            "actor": {
                "reference": "Patient/1",
                "display": "John Doe"
            },
            "required": "required",
            "status": "accepted"
        },
        {
            "actor": {
                "reference": "Practitioner/1",
                "display": "Dr. Smith"
            },
            "required": "required",
            "status": "accepted"
        }
    ]
}
```

### Get All Appointments

```
GET /fhir/Appointment
GET /fhir/Appointment?patient=1
GET /fhir/Appointment?_count=50
```

**Query Parameters:**

- `patient` - Filter by patient ID
- `_count` - Number of results per page

---

## 🩺 CONDITION Resource (Diagnosis)

### Get Single Condition

```
GET /fhir/Condition/{id}
```

**Example Response:**

```json
{
    "resourceType": "Condition",
    "id": "cond-1",
    "clinicalStatus": {
        "coding": [
            {
                "system": "http://terminology.hl7.org/CodeSystem/condition-clinical",
                "code": "active"
            }
        ]
    },
    "category": [
        {
            "coding": [
                {
                    "system": "http://terminology.hl7.org/CodeSystem/condition-category",
                    "code": "encounter-diagnosis"
                }
            ]
        }
    ],
    "code": {
        "coding": [
            {
                "system": "http://snomed.info/sct",
                "code": "709564005",
                "display": "Tooth disease"
            }
        ],
        "text": "Karies Gigi"
    },
    "subject": {
        "reference": "Patient/1",
        "display": "John Doe"
    },
    "recordedDate": "2026-02-13"
}
```

### Get All Conditions

```
GET /fhir/Condition
GET /fhir/Condition?patient=1
```

---

## 🔧 PROCEDURE Resource (Tindakan)

### Get Single Procedure

```
GET /fhir/Procedure/{id}
```

**Example Response:**

```json
{
    "resourceType": "Procedure",
    "id": "proc-1",
    "status": "completed",
    "code": {
        "coding": [
            {
                "system": "http://snomed.info/sct",
                "code": "108290001",
                "display": "Dental procedure"
            }
        ],
        "text": "Penambalan gigi"
    },
    "subject": {
        "reference": "Patient/1",
        "display": "John Doe"
    },
    "performedDateTime": "2026-02-13T14:30:00+07:00",
    "performer": [
        {
            "actor": {
                "reference": "Practitioner/1",
                "display": "Dr. Smith"
            }
        }
    ]
}
```

### Get All Procedures

```
GET /fhir/Procedure
GET /fhir/Procedure?patient=1
```

---

## 🧪 Testing dengan Hoppscotch

### 1. Get Patient by ID

```
Method: GET
URL: https://dentix.my.id/api/fhir/Patient/1
```

### 2. Get All Patients

```
Method: GET
URL: https://dentix.my.id/api/fhir/Patient
```

### 3. Get Patient Everything

```
Method: GET
URL: https://dentix.my.id/api/fhir/Patient/1/$everything
```

### 4. Get Appointments for Patient

```
Method: GET
URL: https://dentix.my.id/api/fhir/Appointment?patient=1
```

### 5. Get Conditions for Patient

```
Method: GET
URL: https://dentix.my.id/api/fhir/Condition?patient=1
```

### 6. Get Procedures for Patient

```
Method: GET
URL: https://dentix.my.id/api/fhir/Procedure?patient=1
```

---

## 📊 FHIR Compliance

### Supported Features:

✅ FHIR R4 JSON format
✅ Bundle resources (searchset, collection)
✅ Pagination support
✅ Patient $everything operation
✅ Search parameters (patient, \_count)
✅ Proper FHIR resource types
✅ Reference links between resources
✅ Meta information (lastUpdated)

### SNOMED CT Codes Used:

- `709564005` - Tooth and/or associated structures disease
- `108290001` - Dental procedure
- `387713003` - Surgical procedure

---

## 📝 Notes

1. **Public Endpoints**: FHIR endpoints are public (no authentication required) for interoperability
2. **Read-Only**: Currently only GET operations are supported
3. **Pagination**: Use `_count` parameter to control page size
4. **Filtering**: Use `patient` parameter to filter by patient ID

---

## 🔗 FHIR Standards Reference

- FHIR R4 Specification: http://hl7.org/fhir/
- Patient Resource: http://hl7.org/fhir/patient.html
- Appointment Resource: http://hl7.org/fhir/appointment.html
- Condition Resource: http://hl7.org/fhir/condition.html
- Procedure Resource: http://hl7.org/fhir/procedure.html
