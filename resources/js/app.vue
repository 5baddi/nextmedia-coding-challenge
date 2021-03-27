  
<template>
    <div>
        <select name="categories" @change="fetchByCategory()" style="margin-bottom: 1rem">
            <option :value="null" :selected="selectedCategory === null">Select a category</option>
            <option v-for="category in categories" :key="category.id" :value="category.id" v-model="selectedCategory" :selected="category.id === selectedCategory">{{ category.name }}</option>
        </select>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th @click="sortByPrice()">Price</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td><img :src="product.image" alt="Product thumbnail"/></td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.description }}</td>
                    <td>{{ product.price }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
  name: 'App',
  computed: {
      products(){
          return this.$store.state.products
      }
  },
  methods: {
      fetchProducts(){
          this.$http.get('v1/products')
            .then(response => {
                this.$store.commit('setProducts', response.data)
            })
            .catch(error => {
                console.log(error)
            })
      },
      sortByPrice(){
          this.products.sort(this.sortBy('price', false))
      },
      sortBy(field, isAsc){
          return function(a, b){
              let result = 0
              if(!a.hasOwnProperty(field) || !b.hasOwnProperty(field)){
                return result
              }

              let dataA = (typeof a[field] === "string") ? a[field].toUpperCase() : a[field]
              let dataB = (typeof b[field] === "string") ? b[field].toUpperCase() : b[field]

              if(dataA > dataB){
                result = 1
              }else if(dataA < dataB){
                result = -1
              }

              return result * (isAsc == true ? 1 : -1)
          }
      },
      fetchByCategory(){
          if(this.selectedCategory !== null){
              this.$http.get(`v1/products/${this.selectedCategory}`)
                .then(response => {
                    this.$store.commit('setProducts', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
          }
      }
    },
    mounted(){
        if(typeof this.products === "undefined" || this.products === null || Object.values(this.products).length === 0){
            this.fetchProducts()
        }
    },
    data(){
        return {
            selectedCategory: null,
        }
    }
}
</script>