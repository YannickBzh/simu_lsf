export const myLoginRoutine = () => {
    this.axios
        .post('https://accounts.zoho.eu/oauth/v2/token', {
            headers: { 'Access-Control-Allow-Origin': true },
            client_id: "1000.54YEA59SUQ8ITERJO5YC2R1MMXRTPR",
            client_secret: "717a3e8e706b4a55d54ae4b0e00ddb32019353db8b",
            refresh_token: "1000.0979c5b0413433840d671c3886d73e54.8e9ed8a1a33eb9e6736b9d63fa882de9",
            grant_type: "1000.0979c5b0413433840d671c3886d73e54.8e9ed8a1a33eb9e6736b9d63fa882de9"
        })
        .then(response => (console.log(response.data)))
        .catch(error => console.log(error));
  }