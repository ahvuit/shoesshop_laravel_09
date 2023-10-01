<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Response;
use App\Models\OrderOrderDetails;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orderArray = array();
            $orders = Order::all();
            foreach ($orders as $order) {
                $orderDetails = OrderDetails::where('orderId', $order->_id)->get();
                $newOrder = new OrderOrderDetails($order, $orderDetails);

                $orderArray[] = $newOrder;
            }
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $orderArray,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(Request $request)
    {
        try {
            $total = 0;
            $o = $request->input('orderModel');

            $order = Order::create([
                'userId' => $o['userId'],
                'firstName' => $o['firstName'],
                'lastName' => $o['lastName'],
                'statusId' => $o['statusId'],
                'phone' => $o['phone'],
                'email' =>$o['email'],
                'note' => $o['note'],
                'total' => $o['total'],
                'payment' => false,
                'momo' => null,
                'address' => $o['userId'],
                'createdDate' => now()->format('Y-m-d H:i:s'),
                'bookingDate' => now()->format('Y-m-d H:i:s'),
                'deliveryDate' => now()->format('Y-m-d H:i:s'),
            ]);

            $orderDetailsArray = array();
            foreach($request->input('listOrderDetails') as $orderDetail) {
                $newOrderDetails = OrderDetails::create([
                    'orderId' => $order->id,
                    'productId' => $orderDetail['productId'],
                    'quantity' => $orderDetail['quantity'],
                    'size' => $orderDetail['size'],
                    'price' => $orderDetail['price'],
                    'total' => $orderDetail['price']*$orderDetail['quantity'],
                ]);
                $total += $newOrderDetails->total;
                // set any other fields you need
                $orderDetailsArray[] = $newOrderDetails;
            }

            $order->deliveryDate = date('Y-m-d H:i:s', strtotime("+3 days"));
            $order->total = $total;
            $order->save();

            $newProduct = new OrderOrderDetails($order, $orderDetailsArray);

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $newProduct,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function detail($id)
    {
        try {
            $order = Order::find($id);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'Cannot find order',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }

            $orderDetails = OrderDetails::where('orderId', $id)->get();

            $newProduct = new OrderOrderDetails($order, $orderDetails);

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $newProduct,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getOrderByUserId($id)
    {
        try {
            $orders = Order::where('userId', $id)->get();

            if (!$orders) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'Cannot find order',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }

            $orderArray = array();
            foreach ($orders as $order) {
                $orderDetails = OrderDetails::where('orderId', $order->_id)->get();
                $newOrder = new OrderOrderDetails($order, $orderDetails);

                $orderArray[] = $newOrder;
            }

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $orderArray,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function payment($id)
    {
        try {
            $findProduct = Order::find($id);
            if (!$findProduct) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'Cannot payment order',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            $findProduct->payment = true;
            $findProduct->save();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $findProduct,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
