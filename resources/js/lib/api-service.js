const apiBase = "/api";

export const getUsers = async function (userId) {
    const response = await fetch(`${apiBase}/users`);
    return response.json();
};

export const getUser = async function () {
    const response = await fetch(`${apiBase}/users/{$userId}`);
    return response.json();
};

export const getInteriors = async function () {
    const response = await fetch(`${apiBase}/interiors`);
    return response.json();
};

export const getMyInteriors = async function () {
    const response = await fetch(`${apiBase}/interiors/mine`);
    return response.json();
};

export const getEachInteriors = async function (userId) {
    const response = await fetch(`${apiBase}/interiors/${userId}`);
    return response.json();
};

// export const getInterior = async function (interiorId) {
//     const response = await fetch(`${apiBase}/interiors/${interiorId}`);
//     return response.json();
// };

export const getMessages = async function (messageId) {
    const response = await fetch(`${apiBase}/interiors/${messageId}`);
    return response.json();
};

export const postInterior = async function (data) {
    const response = await fetch(`${apiBase}/interiors`, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "multipart/form-data",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    return response.json();
};

export const updateInterior = async function (interiorId, data) {
    const response = await fetch(`${apiBase}/interiors/${interiorId}`, {
        method: "PUT",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "multipart/form-data",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }
    });
    return response.json();
};

export const deleteInterior = async function (interiorId) {
    const response = await fetch(`${apiBase}/interiors/${interiorId}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    return response.json();
};

export const deleteMessage = async function (messageId) {
    const response = await fetch(`${apiBase}/interiors/${messageId}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    return response.json();
};