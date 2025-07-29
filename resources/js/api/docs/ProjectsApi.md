# ProjectsApi

All URIs are relative to *http://localhost:8000/api*

|Method | HTTP request | Description|
|------------- | ------------- | -------------|
|[**createProject**](#createproject) | **POST** /projects | Create a new project|
|[**deleteProject**](#deleteproject) | **DELETE** /projects/{id} | Delete a project|
|[**getProject**](#getproject) | **GET** /projects/{id} | Get a project by ID|
|[**getProjects**](#getprojects) | **GET** /projects | List all projects|
|[**updateProject**](#updateproject) | **PUT** /projects/{id} | Update a project|

# **createProject**
> Project createProject(createProjectRequest)


### Example

```typescript
import {
    ProjectsApi,
    Configuration,
    CreateProjectRequest
} from './api';

const configuration = new Configuration();
const apiInstance = new ProjectsApi(configuration);

let createProjectRequest: CreateProjectRequest; //

const { status, data } = await apiInstance.createProject(
    createProjectRequest
);
```

### Parameters

|Name | Type | Description  | Notes|
|------------- | ------------- | ------------- | -------------|
| **createProjectRequest** | **CreateProjectRequest**|  | |


### Return type

**Project**

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
|**201** | Project created |  -  |
|**401** | Authentication is required |  -  |
|**422** | Input validation failed |  -  |
|**500** | Unexpected internal server error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **deleteProject**
> deleteProject()


### Example

```typescript
import {
    ProjectsApi,
    Configuration
} from './api';

const configuration = new Configuration();
const apiInstance = new ProjectsApi(configuration);

let id: number; // (default to undefined)

const { status, data } = await apiInstance.deleteProject(
    id
);
```

### Parameters

|Name | Type | Description  | Notes|
|------------- | ------------- | ------------- | -------------|
| **id** | [**number**] |  | defaults to undefined|


### Return type

void (empty response body)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
|**204** | Project deleted |  -  |
|**401** | Authentication is required |  -  |
|**404** | Resource not found |  -  |
|**500** | Unexpected internal server error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getProject**
> Project getProject()


### Example

```typescript
import {
    ProjectsApi,
    Configuration
} from './api';

const configuration = new Configuration();
const apiInstance = new ProjectsApi(configuration);

let id: number; // (default to undefined)

const { status, data } = await apiInstance.getProject(
    id
);
```

### Parameters

|Name | Type | Description  | Notes|
|------------- | ------------- | ------------- | -------------|
| **id** | [**number**] |  | defaults to undefined|


### Return type

**Project**

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
|**200** | Project found |  -  |
|**401** | Authentication is required |  -  |
|**404** | Resource not found |  -  |
|**500** | Unexpected internal server error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getProjects**
> Array<Project> getProjects()


### Example

```typescript
import {
    ProjectsApi,
    Configuration
} from './api';

const configuration = new Configuration();
const apiInstance = new ProjectsApi(configuration);

const { status, data } = await apiInstance.getProjects();
```

### Parameters
This endpoint does not have any parameters.


### Return type

**Array<Project>**

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
|**200** | List of projects |  -  |
|**401** | Authentication is required |  -  |
|**500** | Unexpected internal server error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **updateProject**
> Project updateProject(updateProjectRequest)


### Example

```typescript
import {
    ProjectsApi,
    Configuration,
    UpdateProjectRequest
} from './api';

const configuration = new Configuration();
const apiInstance = new ProjectsApi(configuration);

let id: number; // (default to undefined)
let updateProjectRequest: UpdateProjectRequest; //

const { status, data } = await apiInstance.updateProject(
    id,
    updateProjectRequest
);
```

### Parameters

|Name | Type | Description  | Notes|
|------------- | ------------- | ------------- | -------------|
| **updateProjectRequest** | **UpdateProjectRequest**|  | |
| **id** | [**number**] |  | defaults to undefined|


### Return type

**Project**

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
|**200** | Project updated |  -  |
|**401** | Authentication is required |  -  |
|**404** | Resource not found |  -  |
|**422** | Input validation failed |  -  |
|**500** | Unexpected internal server error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

