package wishlist.web;

import javax.validation.Valid;
import lombok.Value;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.dao.EmptyResultDataAccessException;
import org.springframework.http.HttpStatus;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.Errors;
import org.springframework.web.bind.annotation.*;
import wishlist.User;
import wishlist.UserWishMapping;
import wishlist.UserWishMappingId;
import wishlist.Wish;
import wishlist.data.UserWishMappingRepository;
import wishlist.data.WishRepository;

import java.util.ArrayList;
import java.util.List;

@Controller
@RequestMapping("/mywishlist")
@Slf4j
public class MyWishlistController {

    private User currentUser;

    private WishRepository wishRepository;

    private UserWishMappingRepository userWishMappingRepository;

    @Autowired
    public MyWishlistController(WishRepository wishRepository, UserWishMappingRepository userWishMappingRepository){
        this.wishRepository = wishRepository;
        this.userWishMappingRepository = userWishMappingRepository;
    }

    @ModelAttribute(name = "wish")
    public Wish wish() { return new Wish(); }

    @ModelAttribute
    public void getWishes(Model model) {
        currentUser = (User) SecurityContextHolder.getContext().getAuthentication().getPrincipal();
        List<UserWishMapping> userWishMappings = userWishMappingRepository.findAllByUser(currentUser);

        List<Wish> allWishes = new ArrayList<>();
        for (UserWishMapping userWishMapping : userWishMappings){
            allWishes.add(userWishMapping.getWish());
        }

        model.addAttribute("wishes", allWishes);
    }

    @GetMapping
    public String showMyWishlist() {
        return "mywishlist"; }

    @GetMapping("/add")
    public String showFormToAddItem() { return "additem"; }

    @PostMapping
    public String addItem(@Valid Wish wish, Errors errors) {
        if (errors.hasErrors()){
            System.out.println(errors);
            return "redirect:/mywishlist/add";
        }

        Wish savedWish = wishRepository.save(wish);
        currentUser = (User) SecurityContextHolder.getContext().getAuthentication().getPrincipal();

        UserWishMappingId id = new UserWishMappingId();
        id.setUserId(currentUser.getId());
        id.setWishId(savedWish.getId());

        UserWishMapping userWishMapping = new UserWishMapping(currentUser, savedWish);
        userWishMapping.setId(id);
        userWishMappingRepository.save(userWishMapping);

        return "redirect:/mywishlist";
    }

    @GetMapping("/wish-delete/{wishId}")
    public String deleteWish(@PathVariable("wishId") int id) {
        try{
            List<Wish> curWishes = (List<Wish>) wishRepository.findAll();
            for (Wish wish : curWishes) {
                System.out.println(wish);
            }
            wishRepository.deleteById(id);
            System.out.println("done");
        } catch (Exception e) {
            System.out.println("xyj");
        }

        return "redirect:/mywishlist";
    }
}
