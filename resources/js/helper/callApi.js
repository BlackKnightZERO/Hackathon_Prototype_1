export default{
    methods:{
        async callApi(method, url, payload) {
            try {
               return await axios({
                    method: method,
                    url: url,
                    data: payload,
                  });
            } catch (e) {
                return e.response
            }
        },
    }
}