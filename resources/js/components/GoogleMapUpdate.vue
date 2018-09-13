<template>
  <div>
    <div>
      <h1>Update place:</h1>
      <div v-if="updatedPlace" class="alert alert-success">{{placeAddress}} was updated to {{updatedPlace}}</div>
      <div v-if="error" class="alert alert-danger">{{error}}</div>
      <div class="input-group">
        <gmap-autocomplete
          @place_changed="setPlace"
          v-model="place.address"
          class="form-control">
        </gmap-autocomplete>
        <span class="input-group-btn">
          <button @click="addMarker" class="btn btn-md btn-primary">Search</button>
          <button @click="updatePlace" class="btn btn-md btn-success">Update</button>
        </span>
      </div>
      <br/>
    </div>
    <br>
    <gmap-map
      :center="center"
      :zoom="8"
      style="width:100%;  height: 400px;"
    >
      <gmap-marker
        v-if="marker"
        :position="marker.position"
        @click="center=marker.position"
      ></gmap-marker>
    </gmap-map>
  </div>
</template>

<script>
export default {
  name: "GoogleMap",
    props: {
      place: {
        required: true
      },
      placeAddress: {
        required: true
      }
    },
  data() {
    return {
      center: {},
      marker: null,
      currentPlace: null,
      updatedPlace: null,
      error: null
    }
  },
  mounted(){
    this.setPlace(this.place);
    this.addInitialMarker();
  },
  methods: {
    setPlace(place) {
      this.currentPlace = place;
    },
    addInitialMarker(){
      if (this.currentPlace) {
        const marker = {
          lat: this.currentPlace.lat,
          lng: this.currentPlace.lng
        };
        this.marker = { position: marker };
        this.place = this.currentPlace;
        this.center = marker;
        this.currentPlace = null;
      }
    },
    addMarker() {
      if (this.currentPlace) {
        const marker = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng()
        };
        this.marker = { position: marker };
        this.place.address = this.formAddress(this.currentPlace.address_components);
        this.place.lat = marker.lat;
        this.place.lng = marker.lng;
        this.center = marker;
        this.currentPlace = null;
      }
    },
    updatePlace() {
      if(this.place.address !== this.placeAddress){
        axios({
          method: 'put',
          url: '/places/' + this.place.id, 
          data: {
            address: this.place.address,
            lat: this.place.lat,
            lng: this.place.lng
          }
        }).then((response) => {
          this.error = false;
          this.updatedPlace = response.data;
        })
        .catch((error) => {
          this.updatedPlace = false;
          console.log(error);
        });
      } else {
        this.error = 'Please select another place';
      }
    },
    formAddress(array){
      let address = '';
      array.forEach(function(item){
        address += item.long_name + ' ';
      });
      return address;
    }
  }
};
</script>