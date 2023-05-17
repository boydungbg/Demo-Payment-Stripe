/* eslint-disable jsx-a11y/alt-text */
import "./App.css";
import React from "react";
import { loadStripe } from "@stripe/stripe-js";
import {
  CardElement,
  Elements,
  useStripe,
  useElements,
} from "@stripe/react-stripe-js";
import axios from "axios";

const CheckoutForm = () => {
  const stripe = useStripe();
  const elements = useElements();

  const handleSubmit = async (e) => {
    e.preventDefault();
    const { error, paymentMethod } = await stripe.createPaymentMethod({
      type: "card",
      card: elements.getElement(CardElement),
    });
    if (!error) {
      const { id } = paymentMethod;
      const data = await axios.post("api/payment", {
        id,
        price: 100000,
      });
      console.log(id);
    }
  };

  return (
    <form onSubmit={handleSubmit} style={{ width: "500px", margin: "0 auto" }}>
      <img src="/download.jpeg" />
      <div>Price: 1000000$</div>
      <CardElement />
      <button type="submit" disabled={!stripe}>
        Pay
      </button>
    </form>
  );
};

const stripe = loadStripe(
  "pk_test_51HgRrLBAfYK2yM8zmd152uYfpaZYTjL28lzNfeeIvdFVuXbLdRp3Mlil69q7T7iciRfrMjchXpmCRsd70WUvFRPq00XNxT0bCO"
);

function App() {
  return (
    <Elements stripe={stripe}>
      <CheckoutForm />
    </Elements>
  );
}

export default App;
