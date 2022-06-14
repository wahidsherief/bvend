import { Box, Container, Grid } from "@mui/material";
import React, { Fragment, useEffect, useState } from "react";
import BottomSheet from "../components/home/BottomSheet";
import ProductCard from "../components/home/ProductCard";
// import Topbar from "../components/home/Topbar";
import useCart from "../hooks/useCart";

const Home = () => {
  const { state } = useCart();
  const [products, setProducts] = useState([]);

  useEffect(() => {
    fetch("https://fakestoreapi.com/products")
      .then((response) => response.json())
      .then((data) => setProducts(data));
  }, []);

  const showBottomSheet = state.cart.length > 0;

  return (
    <Fragment>
      {/* <Topbar /> */}

      <Container sx={{ py: 2, maxWidth: '500px !important', margin: 'auto' }}>
        <Grid container spacing={2}>
          {products.map((product) => (
            <Grid item xs={6} md={6} key={product.id}>
              <ProductCard product={product} />
            </Grid>
          ))}
        </Grid>
      </Container>

      {showBottomSheet && <Box height={110} />}
      <BottomSheet show={showBottomSheet} cart={state.cart} />
    </Fragment>
  );
};

export default Home;


// if (document.getElementById('products')) {
//   ReactDOM.render(<Home />, document.getElementById('products'));
// }
