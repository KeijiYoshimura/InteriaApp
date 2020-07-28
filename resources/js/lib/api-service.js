const apiBase = "/api";

export const getInteriors = async function() {
    const response = await fetch(`${apiBase}/interiors`);
    return response.json();
};

export const getInterior = async function(interiorId) {
    const response = await fetch(`${apiBase}/interiors/${interiorId}`);
    return response.json();
};

export const postInterior = async function(interior) {
    const response = await fetch(`${apiBase}/interiors`, {
        method: "POST",
        body: JSON.stringify(interior),
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    return response.json();
};