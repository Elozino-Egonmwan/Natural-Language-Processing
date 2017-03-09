/*
 * Copyright 2015 Alexander Baumgartner
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
//package at.jku.teaching.swtech;

import java.util.*;
import java.util.Arrays;

/**
 * This class contains demonstration code for various searching and sorting
 * algorithms.
 * 
 * @author Alexander Baumgartner
 */
public class IntArray {
	private int[] packingArray = new int[8];
	private int size;

	public void add(int value) {
		checkRange(size + 1);
		packingArray[size++] = value;
	}

	public int get(int pos) {
		return packingArray[pos];
	}

	public int size() {
		return size;
	}

	private void checkRange(int newLen) {
		while (newLen > packingArray.length)
			packingArray = Arrays.copyOf(packingArray, packingArray.length * 2);
	}

	public void addAll(int... values) {
		checkRange(size + values.length);
		System.arraycopy(values, 0, packingArray, size, values.length);
		size += values.length;
	}

	/**
	 * Search a specified value and return its position. Return -1 if the value
	 * cannot be found.
	 */
	public int search(int searchKey) {
		return search(packingArray, searchKey, 0, size);
	}

	public static int search(int[] array, int searchKey, int fromIdx, int toIdx) {
		for (; fromIdx < toIdx; fromIdx++) {
			// System.out.println("linear search...");
			if (array[fromIdx] == searchKey)
				return fromIdx;
		}
		return -1;
	}

	/**
	 * Search a specified value and return its position. Return -1 if the value
	 * cannot be found. The array must be sorted!
	 */
	public int binarySearch(int searchKey) {
		return binarySearch(packingArray, searchKey, 0, size);
	}

	public static int binarySearch(int[] array, int searchKey, int fromIdx,
			int toIdx) {
		while (fromIdx < toIdx) {
			int mid = (fromIdx + toIdx - 1) / 2;
			if (array[mid] == searchKey)
				return mid;
			else if (array[mid] > searchKey)
				toIdx = mid;
			else
				fromIdx = mid + 1;
		}
		return -1;
	}

	/**
	 * Search a specified value and return its position. Return -1 if the value
	 * cannot be found. The array must be sorted!
	 */
	public int binarySearchRec(int searchKey) {
		return binarySearchRec(packingArray, searchKey, 0, size);
	}

	public static int binarySearchRec(int[] array, int searchKey, int fromIdx,
			int toIdx) {
		// System.out.println("binary search...");
		if (fromIdx >= toIdx)
			return -1;
		int mid = (fromIdx + toIdx - 1) / 2;
		if (array[mid] == searchKey)
			return mid;
		if (array[mid] > searchKey)
			return binarySearchRec(array, searchKey, fromIdx, mid);
		return binarySearchRec(array, searchKey, mid + 1, toIdx);
	}

	public void bubbleSort() {
		for (int out = size - 1; out > 1; out--) {
			for (int in = 0; in < out; in++) {
				if (packingArray[in] > packingArray[in + 1])
					swap(in, in + 1);
			}
		}
	}

	private void swap(int one, int two) {
		int temp = packingArray[one];
		packingArray[one] = packingArray[two];
		packingArray[two] = temp;
	}
	
	/*public void dupRem(){
		int end = size;
		Set<Integer> set = new HashSet<Integer>();
		for(int i = 0; i < end; i++){
		  set.add(packingArray[i]);
		}
		int[] packArray = set.toArray(new int[set.size()]);
		for(int s: packArray){
			// printing the contents of our array
			System.out.println(s);
		}
		//packingArray.toString;
		//return packingArray;
	}*/
	
	public void insertionSort() {
		for (int out = 1; out < size; out++) {
			int temp = packingArray[out];
			int in = out;
			for (; in > 0 && packingArray[in - 1] >= temp; in--)
				packingArray[in] = packingArray[in - 1];
			packingArray[in] = temp;
		}
	}

	private int[] tempMergArr;

	public void mergeSort() {
		this.tempMergArr = new int[size];
		mergeSort(0, size - 1);
	}

	private void mergeSort(int left, int right) {
		if (left < right) {
			int mid = left + (right - left) / 2;
			mergeSort(left, mid);
			mergeSort(mid + 1, right);
			mergeParts(left, mid, right);
		}
	}

	private void mergeParts(int left, int mid, int right) {
		for (int i = left; i <= right; i++)
			tempMergArr[i] = packingArray[i];
		int i = left, k = left;
		for (int j = mid + 1; i <= mid && j <= right; k++) {
			if (tempMergArr[i] <= tempMergArr[j]) {
				packingArray[k] = tempMergArr[i];
				i++;
			} else {
				packingArray[k] = tempMergArr[j];
				j++;
			}
		}
		for (; i <= mid; k++, i++)
			packingArray[k] = tempMergArr[i];
	}

	public void quickSort() {
		quickSort(0, size - 1);
	}

	private void quickSort(int left, int right) {
		if (right - left > 0) {
			int partition = partition(left, right);
			quickSort(left, partition - 1);
			quickSort(partition + 1, right);
		}
	}

	private int partition(int lo, int hi) {
		int pivotValue = packingArray[hi];
		// int pivotIndex = choosePivot(lo, hi);
		// int pivotValue = packingArray[pivotIndex];
		// swap(pivotIndex, hi);
		int storeIndex = lo;
		for (int i = lo; i < hi; i++) {
			if (packingArray[i] <= pivotValue) {
				swap(i, storeIndex);
				storeIndex++;
			}
		}
		swap(storeIndex, hi);
		return storeIndex;
	}

	private int choosePivot(int lo, int hi) {
		if (lo == hi) // Only for performance reasons
			return lo;
		int mid = (lo + hi / 2);
		int pvHi = packingArray[hi];
		int pvLo = packingArray[lo];
		int pvMid = packingArray[mid];
		if (pvHi < pvLo != pvHi < pvMid)
			return hi;
		if (pvLo < pvHi != pvLo < pvMid)
			return lo;
		return mid;
	}

	public int[] toArray() {
		return Arrays.copyOf(packingArray, size);
	}

	@Override
	public String toString() {
		return Arrays.toString(toArray());
	}

	public static int[] mergeArrays(int[] arrayA, int[] arrayB) {
		int[] arrayC = new int[arrayA.length + arrayB.length];
		int aDex = 0, bDex = 0, cDex = 0;
		while (aDex < arrayA.length && bDex < arrayB.length) {
			if (arrayA[aDex] < arrayB[bDex])
				arrayC[cDex++] = arrayA[aDex++];
			else
				arrayC[cDex++] = arrayB[bDex++];
		}
		while (aDex < arrayA.length)
			arrayC[cDex++] = arrayA[aDex++];
		while (bDex < arrayB.length)
			arrayC[cDex++] = arrayB[bDex++];
		return arrayC;
	}
}
