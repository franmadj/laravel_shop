import { createToaster } from "@meforma/vue-toaster"
const toaster = createToaster({ position: "top" });

const populateCategories = async() => {
    let categories = [];
    await axios.get('/api/admin/category')
        .then(response => {
            if (response.data.success) {
                categories = response.data.data
            } else {
                toaster.error(`Error Getting categories`);
            }
        })
        .catch(function(error) {
            toaster.error(error);
        });
    return categories;
}

export default { populateCategories };